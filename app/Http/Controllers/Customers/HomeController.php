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
        // dd($product_best);
        return view('home',
            [
                'product_best' => $product_best
            ]
        );
    }

    
}
