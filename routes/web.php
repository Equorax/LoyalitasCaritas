<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InputNomorTransaksiController;
use App\Http\Controllers\KaryawanDashboardController;
use App\Http\Controllers\UploadTransaksiController;
use App\Http\Controllers\ExportPelangganController;
use App\Http\Controllers\ValiditasTransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home'); 

// Ganti route dashboard default untuk redirect berdasarkan role
Route::get('/dashboard', function () {
    // Beri tahu IDE bahwa auth()->user() mengembalikan instance dari App\Models\User
    /** @var \App\Models\User $user */
    $user = auth()->user();

    if ($user->isKaryawan()) {
        return redirect()->route('dashboard.karyawan');
    } elseif ($user->isPelanggan()) {
        return redirect()->route('dashboard.pelanggan');
    }

    abort(403, 'Role tidak dikenali atau tidak memiliki akses.');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus Karyawan
// Route::get('/dashboard/karyawan', function () {
//     return view('dashboard.karyawan'); // Buat view ini nanti
// })->middleware(['auth', 'role:karyawan'])->name('dashboard.karyawan');

Route::get('/dashboard/karyawan', [KaryawanDashboardController::class, 'index'])
    ->middleware(['auth', 'role:karyawan'])->name('dashboard.karyawan');
 // Pastikan baris ini ada di atas

Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::get('/upload-transaksi', [UploadTransaksiController::class, 'showForm'])->name('upload.transaksi.form');
    Route::post('/upload-transaksi', [UploadTransaksiController::class, 'processUpload'])->name('upload.transaksi.process');
    Route::get('/validitas-transaksi', [ValiditasTransaksiController::class, 'index'])->name('validitas.transaksi');
});

// Tambahkan grup middleware role:karyawan di sekitar route export
Route::middleware(['auth', 'role:karyawan'])->group(function () {
    // ... (route upload lainnya jika ada)
    Route::get('/export-pelanggan', [ExportPelangganController::class, 'export'])->name('export.pelanggan');
});



// Route khusus Pelanggan
Route::get('/dashboard/pelanggan', function () {
    return view('dashboard.pelanggan'); // Buat view ini nanti
})->middleware(['auth', 'role:pelanggan'])->name('dashboard.pelanggan');

// Route untuk input nomor transaksi (hanya untuk pelanggan)
Route::get('/input-nomor-transaksi', [InputNomorTransaksiController::class, 'create'])
    ->middleware(['auth', 'role:pelanggan'])
    ->name('input.nomor.transaksi');

Route::post('/input-nomor-transaksi', [InputNomorTransaksiController::class, 'store'])
    ->middleware(['auth', 'role:pelanggan']);

// Grup route untuk halaman profile (bisa diakses oleh semua user yang login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';