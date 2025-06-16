<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\ProdukMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $product_best = ProdukMaster::with(
            [
            'detailProduk',
            'variant',
            ]
        )
        ->get()
        ->map(function ($item) {
            // Jika produk punya variant
            if ($item->variant->isNotEmpty()) {
                $variantHarga = $item->variant->first()->harga;

                $item->formatted_harga = 'Rp' . number_format($variantHarga, 0, ',', '.');
            }
            elseif ($item->detailProduk->isNotEmpty()) {
                $item->formatted_harga = 'Rp' . number_format($item->detailProduk->first()->harga, 0, ',', '.');
            }
            else {
                $item->formatted_harga = 'Rp0';
            }

            return $item;
        });
        
        $banner = DB::table('home_banner')
            ->latest()->take(3)
            ->select('id_banner', 'gambar', 'judul', 'label')
            ->orderBy('created_at', 'desc')
            ->get();

        $blog = DB::table('blog')
            ->select("id_blog", "judul", "deskripsi", "gambar", "created_at")
            ->orderBy("created_at", "desc")
            ->get();

        return view('home', [
            'product_best' => $product_best,
            'banner' => $banner,
            'blog' => $blog
        ]);
    }

    
}
