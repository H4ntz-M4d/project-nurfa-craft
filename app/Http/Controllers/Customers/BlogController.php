<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $data = Blog::select("id_blog", "judul", "deskripsi", "gambar", "created_at")
            ->orderBy("created_at", "desc")
            ->paginate(3); // Atur jumlah per halaman

        $kategori = DB::table('kategori_produk')
            ->select('id_ktg_produk', 'nama_kategori')
            ->get();

        $product_featured = DB::table('produk_master')
            ->join('detail_produk_master', 'produk_master.id_master_produk', '=', 'detail_produk_master.id_master_produk')
            ->select('produk_master.id_master_produk', 'produk_master.nama_produk', 'produk_master.gambar', 'detail_produk_master.harga', 'produk_master.slug')
            ->orderBy('produk_master.id_master_produk', 'desc')
            ->take(3)
            ->get();

        // Jika permintaan AJAX, kirim hanya bagian blog-nya
        if ($request->ajax()) {
            return view('customers.blog-data', compact('data'))->render();
        }

        // Pertama kali render lengkap
        return view("customers.blog", compact('data', 'kategori', 'product_featured'));
    }



    public function detail($slug)
    {
        $data = Blog::where("id_blog", $slug)
            ->first();

        $komentar = DB::table('comment_post')
            ->join('users', 'comment_post.id_user', '=', 'users.id')
            ->where('comment_post.id_blog', $slug)
            ->select('comment_post.*', 'users.username')
            ->orderBy('comment_post.created_at', 'desc')
            ->get();

        $kategori = DB::table('kategori_produk')
            ->select('id_ktg_produk', 'nama_kategori')
            ->get();

        $product_featured = DB::table('produk_master')
            ->join('detail_produk_master', 'produk_master.id_master_produk', '=', 'detail_produk_master.id_master_produk')
            ->select('produk_master.id_master_produk', 'produk_master.nama_produk', 'produk_master.gambar', 'detail_produk_master.harga', 'produk_master.slug')
            ->orderBy('produk_master.id_master_produk', 'desc')
            ->take(3)
            ->get();


        return view("customers.blog-detail", compact('data', 'komentar', 'kategori', 'product_featured'));
    }

    public function storeComment(Request $request)
    {
        $request->validate([
            'id_blog' => 'required',
            'comment' => 'required',
        ]);

        $user = Auth::user();

        DB::table('comment_post')->insert([
            'id_blog' => $request->id_blog,
            'id_user' => $user->id,
            'comment' => $request->comment,
            'created_at' => now(),
        ]);

        return response()->json([
            'username' => $user->username,
            'comment' => $request->comment,
        ]);
    }
}
