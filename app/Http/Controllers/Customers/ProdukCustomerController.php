<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\ProdukMaster;
use Illuminate\Http\Request;

class ProdukCustomerController extends Controller
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 16);

        $kategori = KategoriProduk::select('id_ktg_produk', 'nama_kategori')->get();

        $product_all = ProdukMaster::with(['detailProduk', 'variant'])->get()
            ->filter(function ($item) {
                if ($item->variant->isNotEmpty()) {
                    return $item->variant->contains(fn($v) => $v->stok > 0);
                }
                if ($item->detailProduk->isNotEmpty()) {
                    return $item->detailProduk->first()->stok > 0;
                }
                return false;
            })
            ->take($limit)
            ->map(function ($item) {
                if ($item->variant->isNotEmpty()) {
                    $item->formatted_harga = 'Rp' . number_format($item->variant->first()->harga, 0, ',', '.');
                } elseif ($item->detailProduk->isNotEmpty()) {
                    $item->formatted_harga = 'Rp' . number_format($item->detailProduk->first()->harga, 0, ',', '.');
                } else {
                    $item->formatted_harga = 'Rp0';
                }
                return $item;
            });

        if ($request->ajax()) {
            return view('customers.product-category', compact('product_all'))->render();
        }

        return view('customers.product', [
            'product_all' => $product_all,
            'kategori' => $kategori,
            'limit' => $limit
        ]);
    }

    public function sortByCategory($id)
    {
        $limit = request()->input('limit', 16);

        $kategori = KategoriProduk::select('id_ktg_produk', 'nama_kategori')->get();

        $product_all = ProdukMaster::with(['detailProduk', 'variant'])
            ->where('id_ktg_produk', $id)
            ->get()
            ->filter(function ($item) {
                if ($item->variant->isNotEmpty()) {
                    return $item->variant->contains(fn($v) => $v->stok > 0);
                }
                if ($item->detailProduk->isNotEmpty()) {
                    return $item->detailProduk->first()->stok > 0;
                }
                return false;
            })
            ->take($limit)
            ->map(function ($item) {
                if ($item->variant->isNotEmpty()) {
                    $item->formatted_harga = 'Rp' . number_format($item->variant->first()->harga, 0, ',', '.');
                } elseif ($item->detailProduk->isNotEmpty()) {
                    $item->formatted_harga = 'Rp' . number_format($item->detailProduk->first()->harga, 0, ',', '.');
                } else {
                    $item->formatted_harga = 'Rp0';
                }
                return $item;
            });


        return view('customers.product', [
            'product_all' => $product_all,
            'kategori' => $kategori,
            'limit' => $limit
        ]);
    }
}
