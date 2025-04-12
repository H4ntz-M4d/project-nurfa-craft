<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    public function index()
    {
        return view('admin.users-management.customers');
    }

    public function data(Request $request)
    {
        if($request->ajax()){
            $data = Customers::select('id_customers','nama','email','no_telp','alamat','created_at','updated_at','slug');
            return DataTables::of($data)
            ->addColumn('checkbox', function($row){
                return '<input type="checkbox" class="form-check-input" value="'.$row->slug.'">';
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
            'no_telp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);
    
        Customers::create($request->all());

        // Kirim response JSON jika request berasal dari AJAX
        return response()->json([ 
            'success' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function destroy($id)
    {
        $customers = Customers::where('slug', $id);
        $customers->delete();
    
        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        Customers::whereIn('slug', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data karyawan berhasil dihapus']);
    }
}
