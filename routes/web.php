<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FakturController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/barang'); // Admin ke halaman barang
        } else {
            return redirect('/dashboard'); // User biasa ke halaman katalog
        }
    }
    return redirect('/login'); // Jika belum login, ke halaman login
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/katalog', [BarangController::class, 'katalog'])->name('barang.katalog');
    Route::post('/faktur/tambah/{id}', [FakturController::class, 'tambahKeFaktur'])->name('faktur.tambah');
    Route::get('/faktur', [FakturController::class, 'index'])->name('faktur.index');
    Route::delete('/faktur/{id}', [FakturController::class, 'hapus'])->name('faktur.hapus');
    Route::post('/faktur/reset', [FakturController::class, 'reset'])->name('faktur.reset');
    Route::post('/faktur/checkout', [FakturController::class, 'checkout'])->name('faktur.checkout');
    Route::get('/faktur/cetak/{invoice}', [FakturController::class, 'cetak'])->name('faktur.cetak');
});

//CRUD untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/barang', BarangController::class);

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');

    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
});

require __DIR__.'/auth.php';
