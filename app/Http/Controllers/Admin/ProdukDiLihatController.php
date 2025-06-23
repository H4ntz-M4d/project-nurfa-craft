<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProdukMaster;
use App\Models\ViewProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ProdukDiLihatController extends Controller
{
    public function index()
    {
        return view('admin.laporan.view-product',[
            'title' => 'Produk dilihat',
            'sub_title' => 'Laporan - Produk dilihat',
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = ProdukMaster::with([
                'detailProduk:id_master_produk,sku,harga,stok',
                'variant:id_master_produk,harga,stok,sku'
            ])
            ->select('id_master_produk', 'nama_produk', 'use_variant', 'gambar','slug')
            ->withCount('viewProduct')
            ->get();

            $totalViews = ViewProduct::count(); // Total semua view dari seluruh produk

            return DataTables::collection($data)
                ->addColumn('nama_produk', function($row){
                    $gambarPath = asset('storage/' . $row->gambar);
                    $label = $row->nama_produk;
                    return 
                    '<div class="d-flex align-items-center">
                        <a href="" class="symbol symbol-50px">
                            <span class="symbol-label" style="background-image:url(\''. $gambarPath .'\');"></span>
                        </a>
                        <div class="ms-5">
                            <a href="" class="text-gray-800 text-hover-primary fs-5 fw-bold">
                                \''. $label .'\'
                            </a>
                        </div>
                    </div>'
                    ;
                })
                ->addColumn('stok', function($row) {
                    if ($row->use_variant === 'yes') {
                        // Total semua stok dari varian
                        return $row->variant->sum('stok');
                    }

                    // Ambil stok dari produk non-variant
                    return $row->detailProduk->first()?->stok ?? 0;
                })
                ->addColumn('jumlah_dilihat', function($row){
                    return $row->view_product_count; // hasil dari withCount()
                })
                ->addColumn('persentase_dilihat', function($row) use ($totalViews) {
                    if ($totalViews === 0) return '0%';
                    
                    $percent = ($row->view_product_count / $totalViews) * 100;
                    return number_format($percent, 2) . '%';
                })
                ->rawColumns(['nama_produk', 'jumlah_dilihat', 'persentase_dilihat', 'stok'])
                ->make(true);
        }
    }
}
