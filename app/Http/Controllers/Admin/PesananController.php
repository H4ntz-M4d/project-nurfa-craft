<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PesananController extends Controller
{
    public function index()
    {
        return view('admin.laporan.pesanan-masuk',[
            'title' => 'Pesanan Masuk',
            'sub_title' => 'Laporan - Pesanan Masuk',
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Pesanan::select(
                    'id_pesanan' ,'id_transaction', 'status', 'jasa_pengiriman',
                    'no_resi', 'harga_pengiriman', 'keterangan',
                    'created_at', 'updated_at', 'slug'
                )
                ->with(['transaction' => function($query) {
                    $query->with(['user' => function($q) {
                        $q->with('customers');
                    }]);
                }])
                ->get()
                ->map(function ($item) {

                    $namaUser = $item->transaction->user->customers->nama ?? $item->transaction->user->username;
                    $emailUser = $item->transaction->user->email;
                    $order = $item->transaction->order_id ?? '-';
                    
                    $item->nama_user = $namaUser;
                    $item->email_user = $emailUser;
                    $item->order_id = $order;
                    $item->tanggaldibuat = Carbon::parse($item->created_at)->timezone('Asia/Jakarta')->format('d F Y, H:i T');
                    $item->tanggaldiupdate = Carbon::parse($item->updated_at)->timezone('Asia/Jakarta')->format('d F Y, H:i T');

                    return $item;
                })->sortByDesc('tanggal');

            return DataTables::collection($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->slug.'" class="form-check-input" value="'.$row->id_pesanan.'">';
                })
                ->addColumn('status', function($row){
                    $status = ucfirst($row->status);
                    
                    if ($row->status === 'proses') {
                        $statusRow = '<span class="badge badge-light-warning d-inline">'.$status.'</span>';
                    } elseif ($row->status === 'dikirim') {
                        $statusRow = '<span class="badge badge-light-info d-inline">'.$status.'</span>';
                    } elseif ($row->status === 'selesai') {
                        $statusRow = '<span class="badge badge-light-success d-inline">'.$status.'</span>';
                    }

                    return $statusRow;
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 update-status-btn" data-bs-toggle="modal" data-bs-target="#kt_modal_status_pesanan"
                                data-slug="'.$row->slug.'"
                                data-status="'.$row->status.'"
                                data-jasa_pengiriman="'.e($row->jasa_pengiriman ?? '').'"
                                data-no_resi="'.e($row->no_resi ?? '').'"
                                data-harga_pengiriman="'.e($row->harga_pengiriman ?? '').'"
                                data-keterangan="'.e($row->keterangan ?? '').'"
                                data-kt-produk-table-filter="add_stock_row">
                                
                                Ubah Status
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-pesanan-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox','action','status'])
                ->make(true);

        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|string|in:proses,dikirim,selesai',
            'jasa_pengiriman' => 'required|string|max:255',
            'no_resi' => 'nullable|string|max:255',
            'harga_pengiriman' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:500',
        ]);
        
        $pesanan = Pesanan::where('slug', $request->slug)->first();

        if ($pesanan) {
            $pesanan->update([
                'status' => $request->status,
                'jasa_pengiriman' => $request->jasa_pengiriman,
                'no_resi' => $request->no_resi,
                'harga_pengiriman' => $request->harga_pengiriman,
                'keterangan' => $request->keterangan,
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status pesanan berhasil diperbarui.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Pesanan tidak ditemukan.'
        ], 404);
    }

    public function destroy($slug)
    {
        $pesanan = Pesanan::where('slug', $slug)->firstOrFail();
        $pesanan->delete();
    
        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        Pesanan::whereIn('slug', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Produk berhasil dihapus']);
    }
}
