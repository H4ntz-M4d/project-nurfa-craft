<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PostinganBlogController extends Controller
{
    public function index()
    {
        return view('admin.utilities.blog-post.blog-list');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('blog')
                ->select('id_blog', 'gambar', 'judul', 'deskripsi', 'tag')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    $tagArray = json_decode($item->tag, true);
                    $item->tag_display = collect($tagArray)->pluck('value')->implode(', ');
                    $item->deskripsi_short = Str::limit(strip_tags($item->deskripsi), 50);
                    return $item;
                });

            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->id_blog.'" class="form-check-input" value="'.$row->id_blog.'">';
                })
                ->addColumn('judul', function($row){
                    return $row->judul = strip_tags($row->judul);
                })
                ->addColumn('tag', function($row){
                    return $row->tag_display ?? '-';
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
                            <a href="/blog-post-edit/'.$row->id_blog.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->id_blog.'" data-kt-category-table-filter="delete_row">Delete</a>
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
        return view('admin.utilities.blog-post.blog-create');
    }

    public function edit($slug)
    {
        $blog = DB::table('blog')->where('id_blog', $slug)->firstOrFail();
        return view('admin.utilities.blog-post.blog-edit', compact('blog'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tag' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|max:5120', // 5MB max
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('blog_images', 'public');
        } else {
            $gambarPath = null;
        }

        DB::table('blog')->insert([
            'id_user' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tag' => $request->tag,
            'created_at' => now(),
            'updated_at' => now(),
            'gambar' => $gambarPath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Blog Post berhasil disimpan',
        ]);
    }

    public function update(Request $request, $slug)
    {
        $request->validate(rules: [
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tag' => 'nullable|string',
        ]);

        $blog = DB::table('blog')->where('id_blog', $slug)->firstOrFail();
        $path = $blog->gambar;

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($blog->gambar) {
                Storage::disk('public')->delete($blog->gambar);
            }

            $path = $request->file('gambar')->store('blog_images', 'public');
        }

        DB::table('blog')->where('id_blog', $slug)->update([
            'id_user' => Auth::id(),
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tag' => $request->tag,
            'created_at' => now(),
            'updated_at' => now(),
            'gambar' => $path,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diperbarui.',
        ]);
    }

    public function destroy($id_blog)
    {
        $blog = DB::table('blog')->where('id_blog', $id_blog)->delete();

        if (!$blog) {
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

        DB::table('blog')->whereIn('id_blog', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Kategori berhasil dihapus']);
    }
}
