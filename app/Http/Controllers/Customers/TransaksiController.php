<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\TransactionDetails;
use App\Models\TransactionDetailVariants;
use App\Models\Transactions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'alamat_pengiriman' => 'required|string',
            'telepon' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $userId = Auth::id();

            do {
                $orderId = 'INV-' . now()->format('Ymd') . '-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
            } while (Transactions::where('order_id', $orderId)->exists());

            // Buat transaksi utama
            $transaksi = Transactions::create([
                'id_user' => $userId,
                'order_id' => $orderId,
                'tanggal' => now(),
                'total' => $request->total,
                'provinsi' => $request->provinsi,
                'kota' => $request->kota,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'telepon' => $request->telepon,
                'status' => 'unpaid'
            ]);



            // Ambil keranjang user
            $keranjangs = Keranjang::with(['keranjang_variant.produk_variant_value.variantAttribute', 'keranjang_variant.produk_variant_value.variantValues'])
                ->where('id_user', $userId)->where('status_produk', 'ada')
                ->get();

            foreach ($keranjangs as $item) {
                // Ambil nama produk dan harga dari master atau variant
                $produk = $item->produk_master;
                $jumlah = $item->jumlah;
                $harga = null;
                $namaProduk = $produk->nama_produk;
                $stok = 0;

                if ($item->keranjang_variant->isNotEmpty()) {
                    $produkVariant = $item->keranjang_variant->first()->produk_variant_value->produkVariant;
                    $harga = $produkVariant->harga;

                    // Ambil kombinasi varian dari keranjang
                    $variantIds = $item->keranjang_variant->pluck('produk_variant_value.id_variant_value')->sort()->values()->toArray();

                    // Cari produk_variant yang cocok
                    foreach ($produk->variant as $varian) {
                        $varianIdsProduk = $varian->variantValues->pluck('id_variant_value')->sort()->values()->toArray();

                        if ($variantIds == $varianIdsProduk) {
                            $stok = $varian->stok;
                            break;
                        }
                    }
                } else {
                    $harga = $produk->detailProduk->first()?->harga ?? 0;
                    $stok = $produk->detailProduk->first()?->stok ?? 0;
                }

                if ($jumlah > $stok) {
                    throw new \Exception("Jumlah beli untuk produk {$produk->nama_produk} melebihi stok tersedia ({$stok})");
                }

                // Simpan ke transaction_details
                $detail = TransactionDetails::create([
                    'id_transaction' => $transaksi->id_transaction,
                    'id_master_produk' => $produk->id_master_produk,
                    'nama_produk' => $namaProduk,
                    'jumlah' => $jumlah,
                    'harga' => $harga
                ]);

                // Simpan detail varian (jika ada)
                foreach ($item->keranjang_variant as $varian) {
                    $pivot = $varian->produk_variant_value;
                    TransactionDetailVariants::create([
                        'id_transaction_detail' => $detail->id_transaction_detail,
                        'id_variant_attributes' => $pivot->id_variant_attributes,
                        'id_variant_value' => $pivot->id_variant_value,
                        'nama_atribut' => $pivot->variantAttribute->nama_variant,
                        'nilai_variant' => $pivot->variantValues->value
                    ]);
                }
            }

            DB::commit();

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $transaksi->total,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => $request->telepon,
                ]
            ];
            // Create Snap transaction
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $transaksi->snap_token = $snapToken;
            $transaksi->save();

            $slug = $transaksi->slug;


            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil disimpan',
                'snap_token' => $snapToken,
                'slug' => $slug,
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function sendWhatsApp($phone, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'),
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $phone,
            'message' => $message,
            'device' => env('FONNTE_DEVICE_ID'),
        ]);


        if ($response->failed()) {
            Log::error('Gagal kirim WA ke ' . $phone . '. Respon: ' . $response->body());
        }

        return $response;
    }

    public function updateStatus($slug)
    {
        $transaksi = Transactions::where('slug', $slug)
            ->select('id_transaction', 'slug', 'status', 'telepon')
            ->firstOrFail();

        try {
            $transaksi->update(['status' => 'paid']);

            Pesanan::createOrFirst([
                'id_transaction' => $transaksi->id_transaction,
                'status' => 'proses',
                'jasa_pengiriman' => null,
                'harga_pengiriman' => null,
                'keterangan' => null,
            ]);

            // Kirim Token via WhatsApp
            $formattedPhone = preg_replace('/^0/', '62', $transaksi->telepon);
            $message = "📩 Pembayaran Diterima!\n"
                . "Halo pelanggan,\n"
                . "Status transaksi Anda dengan kode #{$transaksi->slug} telah berubah menjadi *PAID*.\n"
                . "Terima kasih.";
            $this->sendWhatsApp($formattedPhone, $message);

            return response()->json([
                'success' => true,
                'message' => 'Status transaksi diubah ke Paid',
                'slug' => $slug
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal ubah status transaksi ke Paid',
                'slug' => $slug
            ]);
        }
    }

    public function deleteKeranjang($slug)
    {
        $userId = Auth::user();
        Keranjang::where('id_user', $userId->id)->delete();

        $transaksi = Transactions::where('slug', $slug)
            ->select('order_id')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dihapus',
            'slug' => $userId->slug,
            'invoice' => $transaksi->order_id,
        ]);
    }

    public function historyOrders($slug)
    {
        $user = User::with('customers:id_user,nama')
            ->select('id', 'email', 'slug')
            ->where('slug', $slug)
            ->firstOrFail();

        $transaksi = Transactions::with('details.produk', 'details.variants')
            ->where('status', 'paid')
            ->where('id_user', $user->id)
            ->get()
            ->sortByDesc('updated_at');

        return view(
            'customers.history-order',
            [
                'user' => $user,
                'transaksi' => $transaksi,
            ]
        );
    }

    public function invoiceUser($slug, $invoice)
    {
        $user = User::with('customers:id_user,nama')
            ->select('id', 'email', 'slug')
            ->where('slug', $slug)
            ->firstOrFail();

        $transaksi = Transactions::with('details.produk', 'details.variants')
            ->where('id_user', $user->id)
            ->where('order_id', $invoice)
            ->firstOrFail();

        if ($transaksi->status === 'paid' && $user->id === Auth::user()->id) {
            return view(
                'customers.invoice-order',
                [
                    'user' => $user,
                    'transaksi' => $transaksi,
                ]
            );
        } else {
            return view('error.error-404');
        }
    }
}
