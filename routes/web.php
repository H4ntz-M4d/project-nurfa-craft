<?php

use App\Http\Controllers\Admin\CustomersController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.coba');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get( '/produk', function () {
    return view('admin.catalog.produk');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Begin Route user
    Route::get('/users', [UsersController::class, 'index'])->name('users.index');
    Route::get('/users-data', [UsersController::class, 'data'])->name('user.data'); // json data user
    Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/delete-selected', [UsersController::class, 'destroySelected'])->name('users.destroySelected');

    // end Route user

    // Begin Route Karyawan
    Route::get('/list-karyawan', [KaryawanController::class, 'index'])->name('karyawan.list');
    Route::get('/karyawan-data', [KaryawanController::class, 'data'])->name('karyawan.data'); // json data karyawan
    
    Route::get('/karyawan-view/{slug}', [KaryawanController::class, 'view'])->name('karyawan.view');
    Route::get('/karyawan-settings/{slug}', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::post('/karyawan/store', [KaryawanController::class, 'store'])->name('karyawan.store');
    
    Route::post('/update-karyawan/{slug}', [KaryawanController::class, 'update'])->name('karyawan.update');

    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
    Route::post('/karyawan/delete-selected', [KaryawanController::class, 'destroySelected'])->name('karyawan.destroySelected');
    // End Route Karyawan

    Route::get('/list-gaji', [KaryawanController::class, 'gaji'])->name('karyawan.gaji');

    // begin route customers
    Route::get('/list-customers', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('/customers-data', [CustomersController::class, 'data'])->name('customers.data'); // json data karyawan
    Route::post('/customers/store', [CustomersController::class, 'store'])->name('customers.store');
    Route::delete('/customers/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');
    Route::post('/customers/delete-selected', [CustomersController::class, 'destroySelected'])->name('customers.destroySelected');

});

require __DIR__.'/auth.php';
