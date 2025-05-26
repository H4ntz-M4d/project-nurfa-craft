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
        
        $keranjang = Keranjang::where('id_user', $slug)
        ->with(relations: [
            'produk_master' => function ($query) {
                $query->select('id_master_produk', 'nama_produk')->with([
                    'variant' => function ($query) {
                        $query->select('id_var_produk','id_master_produk','harga','gambar');
                    }
                ]);
            }
        ])
        ->get();

        $userId = auth()->id();
        $subtotal = Keranjang::where('id_user', $userId)->get()->sum(function($item) {
            return $item->produk_master->variant->first()->harga * $item->jumlah;
        });
        // dd($keranjang);
        
        return view('customers.shopping-cart', compact('keranjang','subtotal'));
    }

    public function updateCart(Request $request)
    {
        $cart = Keranjang::where('slug', $request->slug)->first();

        if (!$cart) {
            return response()->json(['success' => false]);
        }

        $cart->jumlah = $request->quantity;
        $cart->save();

        $total = $cart->produk_master->variant->first()->harga * $cart->jumlah;

        $userId = auth()->id();
        $subtotal = Keranjang::where('id_user', $userId)->get()->sum(function($item) {
            return $item->produk_master->variant->first()->harga * $item->jumlah;
        });

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

    public function checkout()
    {
        
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
