<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StokRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class StokRecordController extends Controller
{
    public function index()
    {
        return view('admin.laporan.stok');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = StokRecord::select(
                    'id_stok_record', 'id_user', 'id_master_produk', 'id_var_produk', 'id_detail_produk',
                    'stok_awal', 'stok_masuk', 'stok_akhir', 'keterangan', 'slug', 'created_at'
                )
                ->with(['produkMaster', 'user.karyawan', 'produkVariant.variantValues.variantValues'])
                ->get()
                ->map(function ($item) {
                    $namaProduk = $item->produkMaster->nama_produk ?? '-';

                    if ($item->id_var_produk && $item->produkVariant) {
                        $varian = $item->produkVariant->variantValues
                            ->map(fn($val) => $val->variantValues->value ?? '')
                            ->implode(' - ');
                        $namaProduk .= ' - ' . $varian;
                    }

                    $namaUser = $item->user->karyawan->nama ?? $item->user->username;

                    $item->nama_user = $namaUser;

                    $item->nama_produk = $namaProduk;

                    // Format waktu di sini juga boleh
                    $item->tanggal = Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d F Y, H:i T');

                    return $item;
                });

            return DataTables::collection($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->slug.'" class="form-check-input" value="'.$row->id_stok_record.'">';
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-category-table-filter="delete_row">Delete</a>
                        </div>
                    </div>';
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);

        }
    }
}
