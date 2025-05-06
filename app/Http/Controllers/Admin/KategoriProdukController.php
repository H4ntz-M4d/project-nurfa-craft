<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class KategoriProdukController extends Controller
{
    public function index()
    {
        return view('admin.catalog.kategori-view.kategori');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = KategoriProduk::select('id_ktg_produk','nama_kategori','deskripsi','status','gambar','slug');
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->slug.'" class="form-check-input" value="'.$row->id_ktg_produk.'">';
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
                ->rawColumns(['checkbox', 'action', 'gambar'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.catalog.kategori-view.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'status'=> 'required|in:published,unpublished',
            'meta_desc' => 'nullable',
            'meta_keywords' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('kategori', 'public');
        } else {
            $path = null;
        }

        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'meta_desc' => $request->meta_desc,
            'meta_keywords' => $request->meta_keywords,
            'gambar' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil disimpan',
        ]);
    }

    public function destroy($slug)
    {
        $kategori = KategoriProduk::where('slug', $slug)->firstOrFail();
        $kategori->delete();
    
        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        KategoriProduk::whereIn('slug', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Kategori berhasil dihapus']);
    }

}
