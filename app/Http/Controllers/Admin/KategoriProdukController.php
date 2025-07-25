<?php

namespace App\Http\Controllers\Admin;

use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class KategoriProdukController extends Controller
{
    public function index()
    {
        return view('admin.catalog.kategori-view.kategori',[
            'title' => 'Kategori',
            'sub_title' => 'Catalog - Kategori'
        ]);
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
                            <a href="/kategori-edit/'.$row->slug.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->slug.'" data-kt-category-table-filter="delete_row">Delete</a>
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
        return view('admin.catalog.kategori-view.create',[
            'title' => 'Tambah Kategori',
            'sub_title' => 'Catalog - Tambah Kategori'
        ]);
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

    public function edit($slug)
    {
        $kategori = KategoriProduk::where('slug', $slug)->firstOrFail();
        $gambar = asset('storage/' . $kategori->gambar);

        $title = 'Edit Kategori';
        $sub_title = 'Catalog - Edit Kategori';

        return view('admin.catalog.kategori-view.edit', compact('kategori','gambar','title','sub_title'));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'nullable',
            'status' => 'nullable|in:published,unpublished',
            'meta_desc' => 'nullable',
            'meta_keywords' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $kategori = KategoriProduk::where('slug', $slug)->firstOrFail();
        $path = $kategori->gambar;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($kategori->gambar) {
                Storage::disk('public')->delete($kategori->gambar);
            }

            $path = $request->file('gambar')->store('kategori', 'public');
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'meta_desc' => $request->meta_desc,
            'meta_keywords' => $request->meta_keywords,
            'gambar' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
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
