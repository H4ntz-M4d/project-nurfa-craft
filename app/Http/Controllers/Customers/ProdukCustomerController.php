<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\ProdukMaster;
use Illuminate\Http\Request;

class ProdukCustomerController extends Controller
{
    public function index()
    {
        $kategori = KategoriProduk::select('id_ktg_produk','nama_kategori')->get();
        $product_all = ProdukMaster::with([
            'detailProduk',
            'variant',
        ])
        ->get()
        ->filter(function ($item) {
            // Jika punya varian
            if ($item->variant->isNotEmpty()) {
                return $item->variant->contains(function ($variant) {
                    return $variant->stok > 0;
                });
            }

            // Jika tidak punya varian
            if ($item->detailProduk->isNotEmpty()) {
                return $item->detailProduk->first()->stok > 0;
            }

            return false;
        })
        ->map(function ($item) {
            if ($item->variant->isNotEmpty()) {
                $variantHarga = $item->variant->first()->harga;
                $item->formatted_harga = 'Rp' . number_format($variantHarga, 0, ',', '.');
            } elseif ($item->detailProduk->isNotEmpty()) {
                $item->formatted_harga = 'Rp' . number_format($item->detailProduk->first()->harga, 0, ',', '.');
            } else {
                $item->formatted_harga = 'Rp0';
            }

            return $item;
        });


        // dd($product_all);
        return view('customers.product',
            [
                'product_all' => $product_all,
                'kategori' => $kategori,
            ]
        );
    }
}
