<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class HomeBannerController extends Controller
{
    public function index()
    {
        return view('admin.utilities.home-banner.list-home-banner',[
            'title' => 'Home Banner',
            'sub_title' => 'Utilities - Home Banner',
        ]);
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_add_banner_home"
                            data-id="'.$row->id_banner.'"
                            data-judul="'.$row->judul.'"
                            data-label="'.$row->label.'"
                            data-gambar="'.asset('storage/' . $row->gambar).'"
                            class="menu-link px-3 edit-banner-btn">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->id_banner.'" data-kt-banner-table-filter="delete_row">Delete</a>
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
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ], [
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus bertipe jpeg, png, atau jpg.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 5MB.',
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
            'message' => 'Banner berhasil disimpan',
        ]);
    }

    public function update(Request $request, $id)
    {
        $banner = HomeBanner::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'label' => 'nullable',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($banner->gambar);
            $banner->gambar = $request->file('gambar')->store('banner', 'public');
        }

        $banner->update([
            'judul' => $request->judul,
            'label' => $request->label,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil diperbarui',
        ]);
    }


    public function destroy($id_banner)
    {
        $kategori = DB::table('home_banner')->where('id_banner', $id_banner)->firstOrFail();
        Storage::disk('public')->delete($kategori->gambar);
        DB::table('home_banner')->where('id_banner', $id_banner)->delete();
    
        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        $banners = HomeBanner::whereIn('id_banner', $ids)->get();

        foreach ($banners as $banner) {
            if ($banner->gambar) {
                Storage::disk('public')->delete($banner->gambar);
            }
            $banner->delete();
        }

        return response()->json(['success' => true, 'message' => 'Data banner berhasil dihapus']);
    }
}
