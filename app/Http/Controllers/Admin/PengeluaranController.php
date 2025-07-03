<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PengeluaranController extends Controller
{
    public function index()
    {
        return view('admin.laporan.pengeluaran.list-pengeluaran', [
            'title' => 'Pengeluaran',
            'sub_title' => 'Laporan - Pengeluaran',
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = Pengeluaran::select('id_pengeluaran', 'nama_pengeluaran', 'kategori_pengeluaran', 'jumlah_pengeluaran',
                    'tanggal_pengeluaran', 'keterangan', 'slug', 'id_user')
                ->with(['user' => function($q) {
                    $q->select('id', 'username')->with(['karyawan' => function($q) {
                        $q->select('id_user', 'nama');
                    }]);
                }]);

            if ($request->start && $request->end) {
                $start = $request->start . ' 00:00:00';
                $end = $request->end . ' 23:59:59';

                $query->whereBetween('tanggal_pengeluaran', [$start, $end]);
            }

            $data = $query->get()->map(function ($item) {
                    $namaUser = $item->user->karyawan->nama ?? $item->user->username;
                    $jumlah = 'Rp' . number_format($item->jumlah_pengeluaran, 0, ',', '.') ?? '0';
                    
                    $item->nama_user = $namaUser;
                    $item->jum_pengeluaran = $jumlah;
                    $item->tanggaldibuat = Carbon::parse($item->tanggal_pengeluaran)->timezone('Asia/Jakarta')->format('d F Y, H:i T');

                    return $item;
                })->sortByDesc('tanggal_pengeluaran');

            return DataTables::collection($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->slug.'" class="form-check-input" value="'.$row->id_pengeluaran.'">';
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 edit-pengeluaran-btn" data-bs-toggle="modal" data-bs-target="#kt_modal_status_pengeluaran"
                                data-slug="'.$row->slug.'"
                                data-kt-produk-table-filter="add_stock_row">
                                Edit
                            </a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-pengeluaran-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox','action'])
                ->make(true);

        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'kategori_pengeluaran' => 'required|string|max:255',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'tanggal_pengeluaran' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
            'id_user' => 'nullable|integer',
        ]);

        Pengeluaran::create([
            'nama_pengeluaran' => $validated['nama_pengeluaran'],
            'kategori_pengeluaran' => $validated['kategori_pengeluaran'],
            'jumlah_pengeluaran' => $validated['jumlah_pengeluaran'],
            'tanggal_pengeluaran' => Carbon::parse($validated['tanggal_pengeluaran'])->timezone('Asia/Jakarta'),
            'id_user' => $validated['id_user'] ?? null,
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil disimpan.',
        ]);
    }

    public function getDetail($slug)
    {
        $pengeluaran = Pengeluaran::where('slug', $slug)->firstOrFail();

        return response()->json([
            'nama_pengeluaran' => $pengeluaran->nama_pengeluaran,
            'kategori_pengeluaran' => $pengeluaran->kategori_pengeluaran,
            'jumlah_pengeluaran' => $pengeluaran->jumlah_pengeluaran,
            'tanggal_pengeluaran' => $pengeluaran->tanggal_pengeluaran,
            'keterangan' => $pengeluaran->keterangan,
        ]);
    }

    public function update(Request $request, $slug)
    {
        $validated = $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'kategori_pengeluaran' => 'required|string|max:255',
            'jumlah_pengeluaran' => 'required|numeric|min:0',
            'tanggal_pengeluaran' => 'required|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $pengeluaran = Pengeluaran::where('slug', $slug)->firstOrFail();
        $pengeluaran->update([
            'nama_pengeluaran' => $validated['nama_pengeluaran'],
            'kategori_pengeluaran' => $validated['kategori_pengeluaran'],
            'jumlah_pengeluaran' => $validated['jumlah_pengeluaran'],
            'tanggal_pengeluaran' => Carbon::parse($validated['tanggal_pengeluaran'])->timezone('Asia/Jakarta'),
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil diperbarui.',
        ]);
    }

    public function destroy($slug)
    {
        $pengeluaran = Pengeluaran::where('slug', $slug)->firstOrFail();
        $pengeluaran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil dihapus.',
        ]);
    }

}
