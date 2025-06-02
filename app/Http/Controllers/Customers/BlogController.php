<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $data = Blog::select("id_blog", "judul", "deskripsi", "gambar", "created_at")
            ->orderBy("created_at", "desc")
            ->get();

        return view("customers.blog", compact('data'));
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

        return view("customers.blog-detail", compact('data', 'komentar'));
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
