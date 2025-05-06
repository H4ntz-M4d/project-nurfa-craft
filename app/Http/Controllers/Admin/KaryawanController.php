<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            $data = Karyawan::with('users:id,email')->select('id_karyawan','id_user','nama','no_telp','tgl_lahir','slug');
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id_karyawan.'">';
                })
                ->addColumn('email', function($row){
                    return $row->users->email;
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
        $validator = Validator::make($request->all(), [
            // Step 1: Data pribadi karyawan
            'nama' => 'required|string|min:3|max:255',
            'jkel' => 'required|in:pria,wanita',
            'no_telp' => 'required|digits_between:10,15',
            'alamat' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            
            // Step 2: Akun user
            'username' => 'required|string|min:4|max:50|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }
    
        DB::beginTransaction();
        try {
            // Simpan user dulu
            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            // Simpan data karyawan dengan id_user
            $karyawan = Karyawan::create([
                'nama' => $request->nama,
                'jkel' => $request->jkel,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'id_user' => $user->id,
            ]);
    
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'Karyawan berhasil disimpan',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function view($id)
    {
        $vk = Karyawan::select('nama','no_telp','alamat','tempat_lahir','tgl_lahir','slug')
            ->where('slug',$id)->first();
        return view('admin.users-management.karyawans.details-karyawan', compact('vk'));
    }

    public function edit($id)
    {
        $vk = Karyawan::select('nama','no_telp','alamat','tempat_lahir','tgl_lahir','slug')
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

    public function destroySelected(Request $request): JsonResponse|mixed
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        Karyawan::whereIn('id_karyawan', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data karyawan berhasil dihapus']);
    }

}
