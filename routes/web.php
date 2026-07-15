<?php

use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\DocumentController as MahasiswaDocumentController;
use App\Http\Controllers\Mahasiswa\PengajuanController as MahasiswaPengajuanController;
use App\Http\Controllers\Mahasiswa\ProfileController as MahasiswaProfileController;
use App\Http\Controllers\MasterData\DistrikController;
use App\Http\Controllers\MasterData\FakultasController;
use App\Http\Controllers\MasterData\JenisBantuanController;
use App\Http\Controllers\MasterData\KampungController;
use App\Http\Controllers\MasterData\PerguruanTinggiController;
use App\Http\Controllers\MasterData\PeriodeBansosController;
use App\Http\Controllers\MasterData\ProgramStudiController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\PengajuanController as OperatorPengajuanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', MahasiswaDashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('profil', [MahasiswaProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profil', [MahasiswaProfileController::class, 'update'])->name('profile.update');
        Route::get('dokumen', [MahasiswaDocumentController::class, 'index'])->name('documents.index');
        Route::post('dokumen', [MahasiswaDocumentController::class, 'store'])->name('documents.store');
        Route::delete('dokumen/{documentType}', [MahasiswaDocumentController::class, 'destroy'])
            ->whereIn('documentType', ['ktp', 'kk', 'ktm', 'surat_aktif', 'khs', 'buku_rekening'])
            ->name('documents.destroy');

        Route::post('pengajuan/{pengajuan}/submit', [MahasiswaPengajuanController::class, 'submit'])->name('pengajuan.submit');
        Route::resource('pengajuan', MahasiswaPengajuanController::class)->except('destroy');
    });

    Route::prefix('operator')->name('operator.')->group(function () {
        Route::get('dashboard', OperatorDashboardController::class)->name('dashboard');
        Route::get('pengajuan', [OperatorPengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('pengajuan/{pengajuan}', [OperatorPengajuanController::class, 'show'])->name('pengajuan.show');
        Route::post('pengajuan/{pengajuan}/verify', [OperatorPengajuanController::class, 'verify'])->name('pengajuan.verify');
    });

    Route::prefix('master-data')->name('master-data.')->group(function () {
        Route::resource('periode-bansos', PeriodeBansosController::class)->parameters(['periode-bansos' => 'periodeBansos']);
        Route::resource('jenis-bantuan', JenisBantuanController::class)->parameters(['jenis-bantuan' => 'jenisBantuan']);
        Route::resource('perguruan-tinggi', PerguruanTinggiController::class)->parameters(['perguruan-tinggi' => 'perguruanTinggi']);
        Route::resource('fakultas', FakultasController::class)->parameters(['fakultas' => 'fakultas']);
        Route::resource('program-studi', ProgramStudiController::class)->parameters(['program-studi' => 'programStudi']);
        Route::resource('distrik', DistrikController::class);
        Route::resource('kampung', KampungController::class);
    });
});

require __DIR__.'/auth.php';
