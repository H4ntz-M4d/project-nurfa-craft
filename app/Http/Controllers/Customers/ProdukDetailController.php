<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangVariant;
use App\Models\ProdukGambar;
use App\Models\ProdukMaster;
use App\Models\ProdukVariant;
use App\Models\ProdukVariantValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProdukDetailController extends Controller
{
    public function index($slug)
    {
        $pro_detail = ProdukMaster::where('slug', $slug)
            ->with([
                'kategori_produk',
                'detailProduk',
                'variant' => function($query) {
                    $query->with(['variantValues' => function($q) {
                        $q->with('variantAttribute');
                    }]);
                }
            ])->get()
            ->map(function ($item) {
                if ($item->variant->isNotEmpty()) {
                    $firstAvailableVariant = $item->variant->firstWhere('stok', '>', 0);

                    if ($firstAvailableVariant) {
                        $item->formatted_harga = 'Rp' . number_format($firstAvailableVariant->harga, 0, ',', '.');
                        $item->stok = $firstAvailableVariant->stok;
                        $item->sku = $firstAvailableVariant->sku;
                    } else {
                        // Semua varian stoknya habis
                        $item->formatted_harga = 'Rp' . number_format($item->variant->first()->harga, 0, ',', '.');
                        $item->stok = 0;
                        $item->sku = $item->variant->first()->sku ?? null;
                        $item->is_out_of_stock = true;
                    }
                    
                }
                elseif ($item->detailProduk->isNotEmpty()) {
                    $firstDetail = $item->detailProduk->first();
                    $item->formatted_harga = 'Rp' . number_format($firstDetail->harga, 0, ',', '.');
                    $item->stok = $firstDetail->stok;
                    $item->sku = $firstDetail->sku;
                    $item->is_out_of_stock = $firstDetail->stok <= 0;
                }
                else {
                    $item->formatted_harga = 'Rp0';
                    $item->stok = 0;
                    $item->is_out_of_stock = true;
                }

                return $item;
            })
            ->firstOrFail();


        if ($slug) {
            DB::table('logs_view_product')->insertOrIgnore([
                'id_user' => Auth::id(),
                'id_master_produk' => $pro_detail->id_master_produk,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // dd($pro_detail);
            $variantAttributes = [];

        foreach ($pro_detail->variant as $variant) {
            foreach ($variant->variantValues as $value) {
                $attributeName = $value->variantAttribute->nama_variant;
                $attributeSlug = $value->variantAttribute->slug;
                $optionValue = $value->variantValues->value;
                $optionId = $value->variantValues->id_variant_value;

                $variantAttributes[$attributeName]['slug'] = $attributeSlug;
                $variantAttributes[$attributeName]['values'][$optionId] = $optionValue;
            }
        }

        $produk_img = ProdukGambar::where('id_master_produk', $pro_detail->id_master_produk)->get();

        return view('customers.produk-detail',
            [
                'pro_detail' => $pro_detail,
                'produk_img' => $produk_img,
                'variantAttributes' => $variantAttributes,
            ]
        );
    }

    public function checkVariant(Request $request)
    {
        $variantValueIds = $request->variant_values;
        $id_master_produk = $request->id_master_produk;

        $produkVariant = ProdukVariant::where('id_master_produk', $id_master_produk)
            ->whereHas('variantValues', function ($q) use ($variantValueIds) {
                $q->whereIn('id_variant_value', $variantValueIds);
            }, '=', count($variantValueIds))
            ->with('variantValues')
            ->first();

        if ($produkVariant) {
            return response()->json([
                'success' => true,
                'harga' => $produkVariant->harga,
                'stok' => $produkVariant->stok,
                'out_of_stock' => $produkVariant->stok <= 0,
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'id_master_produk' => 'required|exists:produk_master,id_master_produk',
            'jumlah' => 'required|integer|min:1',
            'variant_values' => 'array', // optional (boleh kosong)
            'variant_values.*' => 'exists:variant_values,id_variant_value',
        ]);

        $userId = Auth::id();
        $idMasterProduk = $request->id_master_produk;
        $jumlah = $request->jumlah;
        $variantValueIds = collect($request->variant_values)->sort()->values(); // sort untuk akurasi perbandingan

        DB::beginTransaction();

        try {
            // Cek apakah produk memiliki variant
            $produk = ProdukMaster::with('variant')->findOrFail($idMasterProduk);
            $hasVariant = $produk->variant->isNotEmpty();

            if ($hasVariant && $variantValueIds->isEmpty()) {
                return response()->json(['message' => 'Varian produk harus dipilih'], 422);
            }

            // Jika produk punya variant, cari kombinasi variant dan cek apakah sudah ada di keranjang
            if ($hasVariant) {
                // Cari produk_variant sesuai kombinasi
                $variantProduk = DB::table('produk_variant_values')
                    ->whereIn('id_variant_value', $variantValueIds)
                    ->select('id_var_produk')
                    ->groupBy('id_var_produk')
                    ->havingRaw('COUNT(*) = ?', [$variantValueIds->count()])
                    ->pluck('id_var_produk')
                    ->first();



                if (!$variantProduk) {
                    return response()->json(['message' => 'Kombinasi varian tidak valid'], 422);
                }

                $produkVariant = ProdukVariant::findOrFail($variantProduk);
                
                if ($produkVariant->stok < $jumlah) {
                    return response()->json(['message' => 'Stok produk tidak mencukupi'], 422);
                }
                // Cek apakah keranjang dengan kombinasi variant sama sudah ada
                $variantProductValueIds = ProdukVariantValues::where('id_var_produk', $variantProduk)
                    ->whereIn('id_variant_value', $variantValueIds)
                    ->pluck('id_product_variant_value')
                    ->sort()
                    ->values();

                $existingCarts = Keranjang::with('keranjang_variant') // tidak perlu nested eager load
                    ->where('id_user', $userId)
                    ->where('id_master_produk', $idMasterProduk)
                    ->get();

                foreach ($existingCarts as $cart) {
                    $cartValueIds = $cart->keranjang_variant
                        ->pluck('id_product_variant_value')
                        ->sort()
                        ->values();

                    if ($variantProductValueIds->toJson() === $cartValueIds->toJson()) {
                        $cart->jumlah += $jumlah;
                        $cart->save();
                        DB::commit();
                        return response()->json(['message' => 'Jumlah produk berhasil diperbarui']);
                    }
                }


                // Jika belum ada → buat baru
                $keranjang = Keranjang::create([
                    'id_user' => $userId,
                    'id_master_produk' => $idMasterProduk,
                    'jumlah' => $jumlah,
                    'slug' => Str::uuid(), // slug unik
                ]);

                foreach ($variantValueIds as $variantValueId) {
                    $pivot = ProdukVariantValues::where([
                        'id_var_produk' => $produkVariant->id_var_produk,
                        'id_variant_value' => $variantValueId
                    ])->first();

                    if ($pivot) {
                        KeranjangVariant::create([
                            'id_keranjang' => $keranjang->id_keranjang,
                            'id_product_variant_value' => $pivot->id_product_variant_value
                        ]);
                    }
                }

                DB::commit();
                return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
            }

            // ==== Produk TANPA variant ====

            $detail = $produk->detailProduk->first();
            if (!$detail || $detail->stok < $jumlah) {
                return response()->json(['message' => 'Stok produk tidak mencukupi'], 422);
            }

            $existing = Keranjang::where([
                'id_user' => $userId,
                'id_master_produk' => $idMasterProduk,
            ])->doesntHave('keranjang_variant') // pastikan bukan produk dengan variant
            ->first();

            if ($existing) {
                $existing->jumlah += $jumlah;
                $existing->save();
                DB::commit();
                return response()->json(['message' => 'Jumlah produk berhasil diperbarui']);
            }

            // Jika belum ada → insert baru
            Keranjang::create([
                'id_user' => $userId,
                'id_master_produk' => $idMasterProduk,
                'jumlah' => $jumlah,
                'status_produk' => 'ada',
                'slug' => Str::uuid(),
            ]);

            DB::commit();
            return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang']);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Gagal menambahkan ke keranjang',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
