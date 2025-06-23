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
        return view('admin.laporan.stok',[
            'title' => 'Laporan Stok',
            'sub_title' => 'Laporan - Laporan Stok',
        ]);
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
                ->make(true);

        }
    }
}
