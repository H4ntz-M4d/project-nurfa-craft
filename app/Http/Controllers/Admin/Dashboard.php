<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'customers') {
            return redirect()->route('home');
        }
        
        return view('dashboard');
    }
}
