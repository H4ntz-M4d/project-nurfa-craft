<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Karyawan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function view(Request $request): View
    {
        $user = Auth::user();
        return view('profile.edit', [
            'user' => $user,
            'title' => 'Pegawai',
            'sub_title' => 'Manajemen Users - Pegawai'
        ]);
    }

    /**
     * Update the user's profile information.
     */

    public function edit($id)
    {
        $vk = Karyawan::with('users:id,email')->select('id_user','nama','no_telp','alamat','tempat_lahir','tgl_lahir','slug')
            ->where('slug',$id)->first();

        $title = 'Pegawai';
        $sub_title = 'Manajemen Users - Pegawai';
        return view('admin.users-management.karyawans.edit-karyawan', compact('vk','title','sub_title'));
    }

    public function update(Request $request, $slug)
    {
        $karyawan = Karyawan::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'nullable|string',
            'tempat_lahir' => 'nullable|string',
            'tgl_lahir' => 'nullable|date',
        ]);

        $karyawan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data karyawan berhasil diperbarui.',
            'data' => $karyawan,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
