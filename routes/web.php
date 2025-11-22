<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\{
    DashboardController, DataDiriController, SiswaController, KelasController, UserController,
    TahunAjaranController, JenisPelanggaranController, JenisPrestasiController,
    WaliKelasController, GuruController, OrangTuaController, VerifikasiDataController, JurusanController, KategoriPelanggaranController, JenisSanksiController, SanksiController};
use App\Http\Controllers\WaliKelas\DataSiswaController;
use App\Http\Controllers\Kesiswaan\PelanggaranController;
use App\Http\Controllers\Siswa\SiswaProfilController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest:web')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});


Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth:web');
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    $role = auth()->user()->level;
    
    switch ($role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'siswa':
            return redirect()->route('siswa.dashboard');
        case 'kepala_sekolah':
            return redirect()->route('kepala-sekolah.dashboard');
        case 'kesiswaan':
        case 'bk':
        case 'wali_kelas':
            return redirect()->route('kesiswaan.dashboard');
        case 'guru':
            return redirect()->route('guru.dashboard');
        case 'orang_tua':
            return redirect()->route('orang-tua.dashboard');
        default:
            return redirect()->route('login');
    }
})->middleware(['auth:web', 'prevent.back'])->name('dashboard');

Route::prefix('siswa')->middleware(['auth:web', 'check.role:siswa', 'prevent.back'])->name('siswa.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [SiswaProfilController::class, 'index'])->name('profil.index');
});

Route::prefix('admin')->middleware(['auth:web', 'check.role:admin', 'prevent.back'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/guru/get-available-users/{currentUserId?}', [GuruController::class, 'getAvailableUsers'])->name('guru.getAvailableUsers');
    Route::get('/data-diri', [DataDiriController::class, 'index'])->name('data-diri.index');
    Route::resource('guru', GuruController::class);
    Route::resource('users', UserController::class);
    Route::resource('wali-kelas', WaliKelasController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('jurusan', JurusanController::class);
    Route::resource('kelas', KelasController::class);
    Route::resource('orang-tua', OrangTuaController::class);
    Route::resource('tahun-ajaran', TahunAjaranController::class);
    Route::resource('kategori-pelanggaran', KategoriPelanggaranController::class);
    Route::resource('jenis-pelanggaran', JenisPelanggaranController::class);
    Route::resource('jenis-prestasi', JenisPrestasiController::class);
    Route::resource('jenis-sanksi', JenisSanksiController::class);
    Route::get('/verifikasi-data', [VerifikasiDataController::class, 'index'])->name('verifikasi-data.index');
    Route::get('/verifikasi-data/{id}/detail', [VerifikasiDataController::class, 'detail'])->name('verifikasi-data.detail');
    Route::post('/verifikasi-data/{id}/approve', [VerifikasiDataController::class, 'approve'])->name('verifikasi-data.approve');
    Route::post('/verifikasi-data/{id}/reject', [VerifikasiDataController::class, 'reject'])->name('verifikasi-data.reject');
    Route::delete('/verifikasi-data/{id}', [VerifikasiDataController::class, 'destroy'])->name('verifikasi-data.destroy');
    Route::resource('pelanggaran', App\Http\Controllers\Admin\PelanggaranController::class);
    Route::post('/pelanggaran/{id}/verifikasi', [App\Http\Controllers\Admin\PelanggaranController::class, 'verifikasi'])->name('pelanggaran.verifikasi');
    Route::resource('prestasi', App\Http\Controllers\Admin\PrestasiController::class);
    Route::post('/prestasi/{id}/verifikasi', [App\Http\Controllers\Admin\PrestasiController::class, 'verifikasi'])->name('prestasi.verifikasi');
    Route::resource('sanksi', SanksiController::class);
    Route::post('/siswa/{id}/reset-password', [SiswaController::class, 'resetPassword'])->name('siswa.reset-password');
    Route::get('/laporan', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [App\Http\Controllers\Admin\LaporanController::class, 'generate'])->name('laporan.generate');
    Route::get('/monitoring-all', [App\Http\Controllers\Admin\MonitoringController::class, 'index'])->name('monitoring-all.index');
    Route::get('/monitoring-all/export-pdf', [App\Http\Controllers\Admin\MonitoringController::class, 'exportPdf'])->name('monitoring-all.export-pdf');
    Route::get('/backup', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backup.index');
    Route::post('/backup/create', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/download/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backup.download');
    Route::get('/backup/download-app', [App\Http\Controllers\Admin\BackupController::class, 'downloadApp'])->name('backup.download-app');
    Route::delete('/backup/{filename}', [App\Http\Controllers\Admin\BackupController::class, 'destroy'])->name('backup.destroy');
});
Route::prefix('kepala-sekolah')->middleware(['auth:web', 'check.role:kepala_sekolah', 'prevent.back'])->name('kepala-sekolah.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\KepalaSekolah\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/data-diri', [App\Http\Controllers\KepalaSekolah\DataDiriController::class, 'index'])->name('data-diri.index');
    Route::put('/data-diri', [App\Http\Controllers\KepalaSekolah\DataDiriController::class, 'update'])->name('data-diri.update');
    Route::get('/data-siswa', [App\Http\Controllers\KepalaSekolah\DataSiswaController::class, 'index'])->name('data-siswa.index');
    Route::get('/data-siswa/{id}', [App\Http\Controllers\KepalaSekolah\DataSiswaController::class, 'show'])->name('data-siswa.show');
    Route::get('/laporan', [App\Http\Controllers\KepalaSekolah\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [App\Http\Controllers\KepalaSekolah\LaporanController::class, 'generate'])->name('laporan.generate');
    Route::get('/monitoring-all', [App\Http\Controllers\KepalaSekolah\MonitoringController::class, 'index'])->name('monitoring-all.index');
    Route::get('/monitoring-all/export-pdf', [App\Http\Controllers\KepalaSekolah\MonitoringController::class, 'exportPdf'])->name('monitoring-all.export-pdf');
});

Route::prefix('kesiswaan')->middleware(['auth:web', 'check.role:kesiswaan,kepala_sekolah,bk,wali_kelas', 'prevent.back'])->name('kesiswaan.')->group(function () {
    Route::get('/dashboard', fn() => view('kesiswaan.dashboard'))->name('dashboard');
    Route::resource('pelanggaran', App\Http\Controllers\Kesiswaan\PelanggaranController::class);
    Route::post('/pelanggaran/{id}/verifikasi', [App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'verifikasi'])->name('pelanggaran.verifikasi');
    Route::resource('prestasi', App\Http\Controllers\Kesiswaan\PrestasiController::class);
    Route::post('/prestasi/{id}/verifikasi', [App\Http\Controllers\Kesiswaan\PrestasiController::class, 'verifikasi'])->name('prestasi.verifikasi');
    Route::get('/laporan', [App\Http\Controllers\Kesiswaan\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [App\Http\Controllers\Kesiswaan\LaporanController::class, 'generate'])->name('laporan.generate');
    Route::get('/data-diri', [App\Http\Controllers\Kesiswaan\DataDiriController::class, 'index'])->name('data-diri.index');
    Route::get('/verifikasi-data', [App\Http\Controllers\Kesiswaan\VerifikasiDataController::class, 'index'])->name('verifikasi-data.index');
    Route::get('/verifikasi-data/{id}/detail', [App\Http\Controllers\Kesiswaan\VerifikasiDataController::class, 'detail'])->name('verifikasi-data.detail');
    Route::post('/verifikasi-data/{id}/approve', [App\Http\Controllers\Kesiswaan\VerifikasiDataController::class, 'approve'])->name('verifikasi-data.approve');
    Route::post('/verifikasi-data/{id}/reject', [App\Http\Controllers\Kesiswaan\VerifikasiDataController::class, 'reject'])->name('verifikasi-data.reject');
    Route::delete('/verifikasi-data/{id}', [App\Http\Controllers\Kesiswaan\VerifikasiDataController::class, 'destroy'])->name('verifikasi-data.destroy');
    Route::resource('sanksi', App\Http\Controllers\Kesiswaan\SanksiController::class);
    Route::resource('pelaksanaan-sanksi', App\Http\Controllers\Kesiswaan\PelaksanaanSanksiController::class);
    Route::get('/monitoring-all', [App\Http\Controllers\Kesiswaan\MonitoringController::class, 'index'])->name('monitoring-all.index');
    Route::get('/monitoring-all/export-pdf', [App\Http\Controllers\Kesiswaan\MonitoringController::class, 'exportPdf'])->name('monitoring-all.export-pdf');
});

Route::prefix('bk')->middleware(['auth:web', 'check.role:bk', 'prevent.back'])->name('bk.')->group(function () {
    Route::get('/dashboard', fn() => view('bk.dashboard'))->name('dashboard');
    Route::get('/data-diri', [App\Http\Controllers\BK\DataDiriController::class, 'index'])->name('data-diri.index');
    Route::resource('konseling', App\Http\Controllers\BK\BimbinganKonselingController::class);
    Route::patch('/konseling/{id}/complete', [App\Http\Controllers\BK\BimbinganKonselingController::class, 'complete'])->name('konseling.complete');
    Route::get('/siswa-perlu-konseling', [App\Http\Controllers\BK\BimbinganKonselingController::class, 'siswaPerluKonseling'])->name('siswa-perlu-konseling.index');
    Route::get('/laporan', [App\Http\Controllers\BK\LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/generate', [App\Http\Controllers\BK\LaporanController::class, 'generate'])->name('laporan.generate');
});

Route::prefix('guru')->middleware(['auth:web', 'check.role:guru', 'prevent.back'])->name('guru.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pelanggaran', App\Http\Controllers\Guru\PelanggaranController::class);
    Route::get('/data-diri', [App\Http\Controllers\Guru\DataDiriController::class, 'index'])->name('data-diri.index');
    Route::get('/siswa-kelas', [App\Http\Controllers\Guru\SiswaKelasController::class, 'index'])->name('siswa-kelas.index');
});
Route::prefix('wali-kelas')
    ->middleware(['auth:web', 'check.role:guru,wali_kelas', 'prevent.back'])
    ->name('wali-kelas.')
    ->group(function () {
        Route::get('/dashboard', fn() => view('wali-kelas.dashboard'))->name('dashboard');
        Route::get('/data-diri', [App\Http\Controllers\WaliKelas\DataDiriController::class, 'index'])->name('data-diri.index');
        Route::resource('data-siswa', App\Http\Controllers\WaliKelas\DataSiswaController::class);
        Route::resource('pelanggaran', App\Http\Controllers\WaliKelas\PelanggaranController::class);
        Route::get('/laporan', [App\Http\Controllers\WaliKelas\LaporanController::class, 'index'])->name('laporan.index');
        Route::post('/laporan/generate', [App\Http\Controllers\WaliKelas\LaporanController::class, 'generate'])->name('laporan.generate');
    });

Route::prefix('orang-tua')->middleware(['auth:web', 'check.role:orang_tua', 'prevent.back'])->name('orang-tua.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\OrangTua\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [App\Http\Controllers\OrangTua\ProfilController::class, 'index'])->name('profil.index');
});