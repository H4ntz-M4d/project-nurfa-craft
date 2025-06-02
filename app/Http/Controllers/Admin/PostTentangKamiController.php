<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostTentangKamiController extends Controller
{
    public function index()
    {
        return view('admin.utilities.about.about');
    }

    public function data (Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('about')
            ->select('id_about', 'judul', 'deskripsi', 'gambar')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                $item->deskripsi_short = Str::limit(strip_tags($item->deskripsi), 50);
                return $item;
            });
            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->id_about.'" class="form-check-input" value="'.$row->id_about.'">';
                })
                ->addColumn('deskripsi', function($row){
                    return $row->deskripsi_short ?? '-';
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
                            <a href="/about-edit/'.$row->id_about.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->id_about.'" data-kt-category-table-filter="delete_row">Delete</a>
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
        return view('admin.utilities.about.about-create');
    }

    public function edit($slug)
    {
        $about = DB::table('about')->where('id_about', $slug)->firstOrFail();
        return view('admin.utilities.about.about-edit', compact('about'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('about', 'public');
        }

        DB::table('about')->insert($data);

        return response()->json([
            'success' => true,
            'message' => 'About us berhasil disimpan',
        ]);
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $about = DB::table('about')->where('id_about', $slug)->firstOrFail();
        $path = $about->gambar;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($about->gambar) {
                Storage::disk('public')->delete($about->gambar);
            }

            $path = $request->file('gambar')->store('about', 'public');
        }

        DB::table('about')->where('id_about', $slug)->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
        ]);
    }

    public function destroy($slug)
    {
        $about = DB::table('about')->where('id_about', $slug)->delete();

        if (!$about) {
            abort(404, 'Blog Post tidak ditemukan');
        }
    
        return response()->json(['success' => true, 'message' => 'Karyawan berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        DB::table('about')->whereIn('id_about', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Kategori berhasil dihapus']);
    }
}
