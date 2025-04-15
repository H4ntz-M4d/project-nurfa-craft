<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\KaryawanDataTable;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('admin.users-management.karyawans.karyawan');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = Karyawan::select('id_karyawan','id_user','nama','email','no_telp','tgl_lahir','slug');
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id_karyawan.'">';
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/karyawan-view/'.$row->slug.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-id="'.$row->slug.'" data-kt-customer-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email',
            'jkel' => 'required|in:pria,wanita',
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'tempat_lahir' => 'required|string',
        ]);

        Karyawan::create($request->all());

        // Kirim response JSON jika request berasal dari AJAX
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function view($id)
    {
        $vk = Karyawan::select('nama','email','no_telp','alamat','tempat_lahir','tgl_lahir','slug')
            ->where('slug',$id)->first();
        return view('admin.users-management.karyawans.details-karyawan', compact('vk'));
    }

    public function edit($id)
    {
        $vk = Karyawan::select('nama','email','no_telp','alamat','tempat_lahir','tgl_lahir','slug')
            ->where('slug',$id)->first();
        return view('admin.users-management.karyawans.edit-karyawan', compact('vk'));
    }

    public function update(Request $request, $slug)
    {
        $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tgl_lahir' => 'nullable|date',
        ]);

        $karyawan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil diperbarui.',
            'data' => $karyawan,
        ]);
    }


    public function destroy($id)
    {
        $karyawan = Karyawan::where('slug', $id);
        $karyawan->delete();

        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }

    public function destroySelected(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        Karyawan::whereIn('id_karyawan', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data karyawan berhasil dihapus']);
    }
}
