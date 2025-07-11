<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class TransaksiRecordController extends Controller
{
    public function index()
    {
        return view('admin.laporan.transaksi',[
            'title' => 'Transaksi Record',
            'sub_title' => 'Laporan - Transaksi Record',
        ]);
    }
    
    public function data(Request $request)
    {
        if ($request->ajax()) {
                $query = Transactions::with(['user.customers'])
                    ->select('id_transaction', 'order_id', 'id_user', 'tanggal', 'total', 'status');

                if ($request->start && $request->end) {
                    $start = $request->start . ' 00:00:00';
                    $end = $request->end . ' 23:59:59';

                    $query->whereBetween('tanggal', [$start, $end]);
                }

                $data = $query->get()->map(function ($item) {
                    $item->nama_user = $item->user->customers->nama ?? $item->user->username;
                    $item->email_user = $item->user->email;
                    $item->tanggal = Carbon::parse($item->tanggal)->timezone('Asia/Jakarta')->format('d F Y, H:i T');
                    $item->total = 'Rp ' . number_format($item->total, 0, ',', '.');
                    return $item;
                });


            return DataTables::collection($data)
                ->addColumn('action', function($row){
                    return '
                    <a href="/invoice-users/'.$row->user->slug.'/'.$row->order_id.'" class="btn btn-sm btn-info btn-flex btn-center btn-active-light-primary">
                        <i class="ki-solid ki-cheque fs-5 ms-1"></i>
                        Invoice
                    </a>';
                })
                ->rawColumns(['action'])
                ->make(true);

        }
    }
}
