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
        $product_all = ProdukMaster::with(
            'variant:id_master_produk,harga,gambar',
        )
        ->get()
        ->map(function ($item) {
            // Format total_harga keranjang
            foreach ($item->variant as $variant) {
                $variant->formatted_harga = 'Rp' . number_format($variant->harga, 0, ',', '.');
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
