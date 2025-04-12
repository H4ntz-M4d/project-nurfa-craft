<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable) {
        return view('admin.users-management.users');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','username','email','created_at');
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'">';
                })
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions 
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-id="'.$row->id.'" data-kt-customer-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })                
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return response()->json(['success' => true, 'message' => 'user berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        User::whereIn('id', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data karyawan berhasil dihapus']);
    }

}
