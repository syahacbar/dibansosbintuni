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
use App\Http\Controllers\Monitoring\DashboardController as MonitoringDashboardController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\PengajuanController as OperatorPengajuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\SuperAdmin\PermissionController as SuperAdminPermissionController;
use App\Http\Controllers\SuperAdmin\RoleController as SuperAdminRoleController;
use App\Http\Controllers\SuperAdmin\SystemSettingController as SuperAdminSystemSettingController;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
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

    Route::prefix('super-admin')->name('super-admin.')->group(function () {
        Route::resource('users', SuperAdminUserController::class);
        Route::resource('roles', SuperAdminRoleController::class);
        Route::resource('permissions', SuperAdminPermissionController::class);
        Route::get('settings', [SuperAdminSystemSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SuperAdminSystemSettingController::class, 'update'])->name('settings.update');
    });

    Route::get('monitoring/dashboard', MonitoringDashboardController::class)->name('monitoring.dashboard');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('{type}/pdf', [ReportController::class, 'pdf'])->name('pdf');
        Route::get('{type}/excel', [ReportController::class, 'excel'])->name('excel');
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
