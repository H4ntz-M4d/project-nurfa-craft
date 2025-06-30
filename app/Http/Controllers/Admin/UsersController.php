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
        return view('admin.users-management.users',[
            'title' => 'All Users',
            'sub_title' => 'Manajemen Users - All Users'
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','username','email','created_at','slug');
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" class="form-check-input" value="'.$row->id.'">';
                })
                ->addColumn('action', function($row){
                    return '
                    <a href="#" class="btn btn-sm btn-danger btn-flex btn-center btn-active-light-primary" data-slug="'.$row->slug.'" data-kt-users-table-filter="delete_row">
                        <i class="ki-solid ki-eraser fs-5 ms-1"></i>
                        Delete
                    </a>
                    ';
                })                
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }
    }

    public function destroy($id)
    {
        $user = User::where('slug', $id)->firstOrFail();
        $user->delete();
    
        return response()->json(['success' => true, 'message' => 'user berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        User::whereIn('slug', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data karyawan berhasil dihapus']);
    }

}
