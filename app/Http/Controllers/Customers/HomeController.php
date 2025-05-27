<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\ProdukMaster;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $product_best = ProdukMaster::with('variant:id_master_produk,harga,gambar')->get();
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
