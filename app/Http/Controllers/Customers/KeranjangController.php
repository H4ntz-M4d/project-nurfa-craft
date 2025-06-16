<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class KeranjangController extends Controller
{
    public function index ($slug)
    {
        if (Auth::user()->slug != $slug) {
            return view('error.error-404');
        }

        $slug = Auth::user()->id;
        
        $keranjang = Keranjang::where('id_user', auth()->id())
            ->with([
                'produk_master.detailProduk',
                'produk_master.variant',
                'keranjang_variant.produk_variant_value.variantAttribute',
                'keranjang_variant.produk_variant_value.variantValues',
            ])
            ->get();

        $userId = auth()->id();


        $subtotal = $keranjang->sum(function ($item) {
            $selectedVariantValueIds = $item->keranjang_variant->pluck('produk_variant_value.id_variant_value')->sort()->values();
            $produk = $item->produk_master;

            $harga = $produk->detailProduk->first()->harga ?? 0;

            if ($item->produk_master->variant->isNotEmpty()) {
                foreach ($produk->variant as $variant) {
                    $variantValueIds = $variant->variantValues->pluck('id_variant_value')->sort()->values();

                    if ($variantValueIds->toJson() === $selectedVariantValueIds->toJson()) {
                        $harga = $variant->harga;
                        break;
                    }
                }
            } elseif ($item->produk_master->detailProduk->isNotEmpty()) {
                $harga = $item->produk_master->detailProduk->first()->harga;
            }

            return $harga * $item->jumlah;
        });
        
        // Periksa stok dan update status_produk jika perlu
        foreach ($keranjang as $item) {
            $produk = $item->produk_master;

            $stok = 0;

            // Jika pakai varian
            if ($item->keranjang_variant->isNotEmpty()) {
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
                $stok = $produk->detailProduk->first()->stok ?? 0;
            }

            // Update status jika stok habis
            if ($stok <= 0) {
                $item->update(['status_produk' => 'habis']);
            }
        }

        // Pisahkan keranjang berdasarkan status_produk
        $keranjangAda = $keranjang->filter(function ($item) {
            return $item->status_produk === 'ada';
        });

        $keranjangHabis = $keranjang->filter(function ($item) {
            return $item->status_produk === 'habis';
        });

        // Hitung subtotal hanya untuk produk yang statusnya 'ada'
        $subtotal = $keranjangAda->sum(function ($item) {
            $selectedVariantValueIds = $item->keranjang_variant->pluck('produk_variant_value.id_variant_value')->sort()->values();
            $produk = $item->produk_master;

            $harga = $produk->detailProduk->first()->harga ?? 0;

            if ($produk->variant->isNotEmpty()) {
                foreach ($produk->variant as $variant) {
                    $variantValueIds = $variant->variantValues->pluck('id_variant_value')->sort()->values();

                    if ($variantValueIds->toJson() === $selectedVariantValueIds->toJson()) {
                        $harga = $variant->harga;
                        break;
                    }
                }
            }

            return $harga * $item->jumlah;
        });
        
        return view('customers.shopping-cart', compact('keranjangAda', 'keranjangHabis', 'subtotal'));
    }

    public function updateCart(Request $request)
    {
        $cart = Keranjang::with([
            'keranjang_variant.produk_variant_value.variantValues',
            'produk_master' => function ($q) {
                $q->with([
                    'detailProduk',
                    'variant.variantValues'
                ]);
            }
        ])->where('slug', $request->slug)->first();

        if (!$cart) {
            return response()->json(['success' => false]);
        }

        $cart->jumlah = $request->quantity;
        $cart->save();

        $produk = $cart->produk_master;

        // Ambil ID variant values dari cart (yang dipilih user)
        $selectedVariantValueIds = $cart->keranjang_variant
            ->pluck('produk_variant_value.id_variant_value')
            ->sort()
            ->values();

        // Default harga dari detail_produk (jika tidak pakai variant)
        $harga = $produk->detailProduk->first()->harga ?? 0;

        // Cek apakah produk punya variant
        if ($produk->variant->isNotEmpty()) {
            foreach ($produk->variant as $variant) {
                $variantValueIds = $variant->variantValues
                    ->pluck('id_variant_value')
                    ->sort()
                    ->values();

                if ($variantValueIds->toJson() === $selectedVariantValueIds->toJson()) {
                    $harga = $variant->harga;
                    break;
                }
            }
        }

        $total = $harga * $cart->jumlah;

        // Hitung subtotal semua keranjang user
        $userId = auth()->id();
        $userCarts = Keranjang::with([
            'keranjang_variant.produk_variant_value.variantValues',
            'produk_master' => function ($q) {
                $q->with([
                    'detailProduk',
                    'variant.variantValues'
                ]);
            }
        ])->where('id_user', $userId)->get();

        $subtotal = 0;

        foreach ($userCarts as $item) {
            $itemProduk = $item->produk_master;

            $itemSelectedVariantValueIds = $item->keranjang_variant
                ->pluck('produk_variant_value.id_variant_value')
                ->sort()
                ->values();

            $itemHarga = $itemProduk->detailProduk->first()->harga ?? 0;

            if ($itemProduk->variant->isNotEmpty()) {
                foreach ($itemProduk->variant as $var) {
                    $varValueIds = $var->variantValues
                        ->pluck('id_variant_value')
                        ->sort()
                        ->values();

                    if ($varValueIds->toJson() === $itemSelectedVariantValueIds->toJson()) {
                        $itemHarga = $var->harga;
                        break;
                    }
                }
            }

            $subtotal += $itemHarga * $item->jumlah;
        }

        return response()->json([
            'success' => true,
            'formatted_total' => number_format($total, 0, ',', '.'),
            'formatted_subtotal' => number_format($subtotal, 0, ',', '.'),
        ]);
    }



    public function getProvinsi()
    {
        // URL API untuk semua provinsi
        $url = "https://wilayah.id/api/provinces.json";

        // Mengambil data dari API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $provinsi = [];
            // Mengambil ID dan nama provinsi dari data API
            foreach ($data['data'] as $item) {
                $provinsi[] = [
                    'id' => $item['code'],
                    'name' => $item['name']
                ];
            }
            return response()->json($provinsi); // Mengembalikan data provinsi dalam format JSON
        }

        return response()->json([], 500); // Jika gagal, kembalikan respon kosong
    }


    public function getKabupaten($provinsiId)
    {
        // URL API untuk kabupaten berdasarkan ID provinsi
        $url = "https://wilayah.id/api/regencies/{$provinsiId}.json";

        // Mengambil data dari API
        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            $kabupaten = [];
            // Mengambil ID dan nama provinsi dari data API
            foreach ($data['data'] as $item) {
                $kabupaten[] = [
                    'id' => $item['code'],
                    'name' => $item['name']
                ];
            }
            return response()->json($kabupaten); // Mengembalikan data kabupaten dalam format JSON
        }

        return response()->json([], 500); // Jika gagal, kembalikan respon kosong
    }

    public function deleteItem($slug)
    {
        $cart = Keranjang::where('slug', $slug)->firstOrFail();
        $cart->delete();

        // Hitung ulang subtotal user
        $userId = auth()->id();
        $subtotal = Keranjang::where('id_user', $userId)->get()->sum(function ($item) {
            return $item->produk_master->variant->first()->harga * $item->jumlah;
        });

        return response()->json([
            'success' => true,
            'formatted_subtotal' => number_format($subtotal, 0, ',', '.'),
        ]);
    }

}
