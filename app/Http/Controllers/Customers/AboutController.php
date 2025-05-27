<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index()
    {
        $about = DB::table('about')
            ->select("id_about", "judul", "deskripsi", "gambar")
            ->orderBy("created_at", "desc")
            ->get();
        return view("customers.about", compact('about'));
    }
}
