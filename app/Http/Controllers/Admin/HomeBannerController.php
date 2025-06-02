<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HomeBannerController extends Controller
{
    public function index()
    {
        return view('admin.utilities.home-banner.list-home-banner');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('home_banner')
            ->select('id_banner', 'gambar', 'judul', 'label')
            ->orderBy('created_at', 'desc');
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->id_banner.'" class="form-check-input" value="'.$row->id_banner.'">';
                })
                ->addColumn('gambar', function($row){
                    $url = asset('storage/' . $row->gambar);
                    return '
                    <div class="symbol symbol-50px">
                        <span class="symbol-label" style="background-image: url(\'' . $url . '\'); background-size: cover;"></span>
                    </div>
                    ';
                })                
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/kategori-edit/'.$row->id_banner.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->id_banner.'" data-kt-category-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox', 'action', 'gambar'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'label' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('banner', 'public');
        } else {
            $path = null;
        }

        HomeBanner::create([
            'judul' => $request->judul,
            'label' => $request->label,
            'gambar' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil disimpan',
        ]);
    }

    public function destroy($id_banner)
    {
        $kategori = DB::table('home_banner')->where('id_banner', $id_banner)->firstOrFail();
        $kategori->delete();
    
        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        DB::table('home_banner')->whereIn('id_banner', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Kategori berhasil dihapus']);
    }
}
