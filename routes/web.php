<?php

use App\Http\Controllers\pages\AbsensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\data_essentials\AreaController;
use App\Http\Controllers\data_essentials\EmployeeTypeController;
use App\Http\Controllers\data_essentials\FormasiTimController;
use App\Http\Controllers\data_essentials\JabatanController;
use App\Http\Controllers\data_essentials\JenisAbsensiController;
use App\Http\Controllers\data_essentials\JenisCutiController;
use App\Http\Controllers\data_essentials\KategoriController;
use App\Http\Controllers\data_essentials\RoleController;
use App\Http\Controllers\data_essentials\SeksiController;
use App\Http\Controllers\data_essentials\ProvinsiController;
use App\Http\Controllers\data_essentials\RoleUserController;
use App\Http\Controllers\data_essentials\WalikotaController;
use App\Http\Controllers\data_essentials\KecamatanController;
use App\Http\Controllers\data_essentials\KelurahanController;
use App\Http\Controllers\data_essentials\KonfigurasiAbsensiController;
use App\Http\Controllers\data_essentials\KonfigurasiCutiController;
use App\Http\Controllers\data_essentials\UnitKerjaController;
use App\Http\Controllers\data_essentials\PulauController;
use App\Http\Controllers\data_essentials\StrukturController;
use App\Http\Controllers\data_essentials\TimController;
use App\Http\Controllers\data_essentials\UserController;
use App\Http\Controllers\pages\KinerjaController;
use App\Http\Controllers\pages\CutiController;

// Route::controller(LoginController::class)->group(function () {
//     Route::get('/', 'login')->name('login.index');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {return redirect('login');})->middleware('guest');
Route::get('/', function () {return redirect('dashboard');})->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    // ---------------------DASHBOARDCONTROLLER----------------------------

    Route::controller(DashboardController::class)->group(function () {
        // Mainmenu
        Route::get('/dashboard', 'index')->name('dashboard.index');
        // Data Essentials
        Route::get('/data_essentials', 'data_essentials')->name('data_essentials.index');
        // Data Assets
        Route::get('/data_assets', 'data_assets')->name('data_assets.index');
        // Data Relasi
        Route::get('/data_relasi', 'data_relasi')->name('data_relasi.index');
    });

    // ---------------------MASTERDATA ESSENTIALS----------------------------

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('user.index');
        Route::get('/users-create', 'create')->name('user.create');
        Route::post('/users', 'store')->name('user.store');
        Route::get('/users-show/{uuid}', 'show')->name('user.show');
        Route::put('/users/{id}', 'update')->name('user.update');
        Route::delete('/users', 'destroy')->name('user.destroy');
        Route::get('/user-profile', 'user_profile')->name('user.profile');
    });

    Route::controller(ProvinsiController::class)->group(function () {
        Route::get('/provinsi', 'index')->name('provinsi.index');
        Route::get('/provinsi-create', 'create')->name('provinsi.create');
        Route::post('/provinsi-store', 'store')->name('provinsi.store');
        Route::get('/provinsi-show/{uuid}', 'show')->name('provinsi.show');
        Route::put('/provinsi-update/{uuid}', 'update')->name('provinsi.update');
        Route::delete('/provinsi-delete', 'destroy')->name('provinsi.destroy');
    });

    Route::controller(WalikotaController::class)->group(function () {
        Route::get('/kota', 'index')->name('walikota.index');
        Route::get('/kota-create', 'create')->name('walikota.create');
        Route::post('/kota', 'store')->name('walikota.store');
        Route::get('/kota-show/{uuid}', 'show')->name('walikota.show');
        Route::put('/kota/{uuid}', 'update')->name('walikota.update');
        Route::delete('/kota', 'destroy')->name('walikota.destroy');
    });

    Route::controller(KecamatanController::class)->group(function () {
        Route::get('/kecamatan', 'index')->name('kecamatan.index');
        Route::get('/kecamatan-create', 'create')->name('kecamatan.create');
        Route::post('/kecamatan', 'store')->name('kecamatan.store');
        Route::get('/kecamatan-show/{uuid}', 'show')->name('kecamatan.show');
        Route::put('/kecamatan/{uuid}', 'update')->name('kecamatan.update');
        Route::delete('/kecamatan', 'destroy')->name('kecamatan.destroy');
    });

    Route::controller(KelurahanController::class)->group(function () {
        Route::get('/kelurahan', 'index')->name('kelurahan.index');
        Route::get('/kelurahan-create', 'create')->name('kelurahan.create');
        Route::post('/kelurahan', 'store')->name('kelurahan.store');
        Route::get('/kelurahan-show/{uuid}', 'show')->name('kelurahan.show');
        Route::put('/kelurahan/{uuid}', 'update')->name('kelurahan.update');
        Route::delete('/kelurahan', 'destroy')->name('kelurahan.destroy');
    });

    Route::controller(UnitKerjaController::class)->group(function () {
        Route::get('/unit-kerja', 'index')->name('unitkerja.index');
        Route::get('/unit-kerja-create', 'create')->name('unitkerja.create');
        Route::post('/unit-kerja', 'store')->name('unitkerja.store');
        Route::get('/unit-kerja-show/{uuid}', 'show')->name('unitkerja.show');
        Route::put('/unit-kerja/{uuid}', 'update')->name('unitkerja.update');
        Route::delete('/unit-kerja', 'destroy')->name('unitkerja.destroy');
    });

    Route::controller(SeksiController::class)->group(function () {
        Route::get('/seksi', 'index')->name('seksi.index');
        Route::get('/seksi-create', 'create')->name('seksi.create');
        Route::post('/seksi', 'store')->name('seksi.store');
        Route::get('/seksi-show/{uuid}', 'show')->name('seksi.show');
        Route::put('/seksi/{uuid}', 'update')->name('seksi.update');
        Route::delete('/seksi', 'destroy')->name('seksi.destroy');
    });

    Route::controller(TimController::class)->group(function () {
        Route::get('/tim', 'index')->name('tim.index');
        Route::get('/tim-create', 'create')->name('tim.create');
        Route::post('/tim', 'store')->name('tim.store');
        Route::get('/tim-show/{uuid}', 'show')->name('tim.show');
        Route::put('/tim/{uuid}', 'update')->name('tim.update');
        Route::delete('/tim', 'destroy')->name('tim.destroy');
    });

    Route::controller(PulauController::class)->group(function () {
        Route::get('/pulau', 'index')->name('pulau.index');
        Route::get('/pulau-create', 'create')->name('pulau.create');
        Route::post('/pulau', 'store')->name('pulau.store');
        Route::get('/pulau-show/{uuid}', 'show')->name('pulau.show');
        Route::put('/pulau/{uuid}', 'update')->name('pulau.update');
        Route::delete('/pulau', 'destroy')->name('pulau.destroy');
    });

    Route::controller(JabatanController::class)->group(function () {
        Route::get('/jabatan', 'index')->name('jabatan.index');
        Route::get('/jabatan-create', 'create')->name('jabatan.create');
        Route::post('/jabatan', 'store')->name('jabatan.store');
        Route::get('/jabatan-show/{uuid}', 'show')->name('jabatan.show');
        Route::put('/jabatan/{uuid}', 'update')->name('jabatan.update');
        Route::delete('/jabatan', 'destroy')->name('jabatan.destroy');
    });

    Route::controller(EmployeeTypeController::class)->group(function () {
        Route::get('/employee-type', 'index')->name('employee-type.index');
        Route::get('/employee-type-create', 'create')->name('employee-type.create');
        Route::post('/employee-type', 'store')->name('employee-type.store');
        Route::get('/employee-type-show/{uuid}', 'show')->name('employee-type.show');
        Route::put('/employee-type/{uuid}', 'update')->name('employee-type.update');
        Route::delete('/employee-type', 'destroy')->name('employee-type.destroy');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/role', 'index')->name('role.index');
        Route::get('/role-create', 'create')->name('role.create');
        Route::post('/role', 'store')->name('role.store');
        Route::get('/role-show/{uuid}', 'show')->name('role.show');
        Route::put('/role/{uuid}', 'update')->name('role.update');
        Route::delete('/role', 'destroy')->name('role.destroy');
    });

    Route::controller(KategoriController::class)->group(function () {
        Route::get('/kategori', 'index')->name('kategori.index');
        Route::get('/kategori-create', 'create')->name('kategori.create');
        Route::post('/kategori', 'store')->name('kategori.store');
        Route::get('/kategori/{uuid}/edit', 'edit')->name('kategori.edit');
        Route::put('/kategori/{uuid}', 'update')->name('kategori.update');
        Route::delete('/kategori', 'destroy')->name('kategori.destroy');
    });

    Route::controller(JenisCutiController::class)->group(function () {
        Route::get('/jenis-cuti', 'index')->name('jenis_cuti.index');
        Route::get('/jenis-cuti-create', 'create')->name('jenis_cuti.create');
        Route::post('/jenis-cuti', 'store')->name('jenis_cuti.store');
        Route::get('/jenis-cuti/{uuid}/edit', 'edit')->name('jenis_cuti.edit');
        Route::put('/jenis-cuti/{uuid}', 'update')->name('jenis_cuti.update');
        Route::delete('/jenis-cuti', 'destroy')->name('jenis_cuti.destroy');
    });

    Route::controller(JenisAbsensiController::class)->group(function () {
        Route::get('/jenis-absensi', 'index')->name('jenis_absensi.index');
        Route::get('/jenis-absensi-create', 'create')->name('jenis_absensi.create');
        Route::post('/jenis-absensi', 'store')->name('jenis_absensi.store');
        Route::get('/jenis-absensi/{uuid}/edit', 'edit')->name('jenis_absensi.edit');
        Route::put('/jenis-absensi/{uuid}', 'update')->name('jenis_absensi.update');
        Route::delete('/jenis-absensi', 'destroy')->name('jenis_absensi.destroy');
    });

    Route::controller(RoleUserController::class)->group(function () {
        Route::get('/role-user', 'index')->name('role_user.index');
        Route::get('/role-user-create', 'create')->name('role_user.create');
        Route::post('/role-user', 'store')->name('role_user.store');
        Route::get('/role-user/{uuid}/edit', 'edit')->name('role_user.edit');
        Route::put('/role-user/{uuid}/update', 'update')->name('role_user.update');
        Route::delete('/role-user', 'destroy')->name('role_user.destroy');
    });

    Route::controller(AreaController::class)->group(function () {
        Route::get('/area', 'index')->name('area.index');
        Route::get('/area-create', 'create')->name('area.create');
        Route::post('/area', 'store')->name('area.store');
        Route::get('/area/{uuid}/edit', 'edit')->name('area.edit');
        Route::put('/area/{uuid}/update', 'update')->name('area.update');
        Route::delete('/area', 'destroy')->name('area.destroy');
    });

    Route::controller(StrukturController::class)->group(function () {
        Route::get('/struktur', 'index')->name('struktur.index');
        Route::get('/struktur-create', 'create')->name('struktur.create');
        Route::post('/struktur', 'store')->name('struktur.store');
        Route::get('/struktur/{uuid}/edit', 'edit')->name('struktur.edit');
        Route::put('/struktur/{uuid}/update', 'update')->name('struktur.update');
        Route::delete('/struktur', 'destroy')->name('struktur.destroy');
    });

    Route::controller(FormasiTimController::class)->group(function () {
        Route::get('/formasi-tim', 'index')->name('formasi_tim.index');
        Route::get('/formasi-tim-create', 'create')->name('formasi_tim.create');
        Route::post('/formasi-tim', 'store')->name('formasi_tim.store');
        Route::get('/formasi-tim/{uuid}/edit', 'edit')->name('formasi_tim.edit');
        Route::put('/formasi-tim/{uuid}/update', 'update')->name('formasi_tim.update');
        Route::delete('/formasi-tim', 'destroy')->name('formasi_tim.destroy');
    });

    Route::controller(KonfigurasiCutiController::class)->group(function () {
        Route::get('/konfigurasi-cuti', 'index')->name('konfigurasi_cuti.index');
        Route::get('/konfigurasi-cuti-create', 'create')->name('konfigurasi_cuti.create');
        Route::post('/konfigurasi-cuti', 'store')->name('konfigurasi_cuti.store');
        Route::get('/konfigurasi-cuti/{uuid}/edit', 'edit')->name('konfigurasi_cuti.edit');
        Route::put('/konfigurasi-cuti/{uuid}/update', 'update')->name('konfigurasi_cuti.update');
        Route::delete('/konfigurasi-cuti', 'destroy')->name('konfigurasi_cuti.destroy');
    });

    Route::controller(KonfigurasiAbsensiController::class)->group(function () {
        Route::get('/konfigurasi-absensi', 'index')->name('konfigurasi_absensi.index');
        Route::get('/konfigurasi-absensi-create', 'create')->name('konfigurasi_absensi.create');
        Route::post('/konfigurasi-absensi', 'store')->name('konfigurasi_absensi.store');
        Route::get('/konfigurasi-absensi/{uuid}/edit', 'edit')->name('konfigurasi_absensi.edit');
        Route::put('/konfigurasi-absensi/{uuid}/update', 'update')->name('konfigurasi_absensi.update');
        Route::delete('/konfigurasi-absensi', 'destroy')->name('konfigurasi_absensi.destroy');
    });

    // KINERJA
    Route::controller(KinerjaController::class)->group(function () {
        Route::get('/kinerja', 'index')->name('kinerja.index');
        Route::get('/my-kinerja', 'my_index')->name('kinerja.saya');
        Route::get('/kinerja-create', 'create')->name('kinerja.create');
        Route::post('/kinerja', 'store')->name('kinerja.store');
        Route::get('/kinerja/{uuid}/edit', 'edit')->name('kinerja.edit');
        Route::put('/kinerja/{uuid}/update', 'update')->name('kinerja.update');
        Route::delete('/kinerja', 'destroy')->name('kinerja.destroy');
        Route::get('/formasi', 'formasi')->name('formasi.index');
    });

    // CUTI
    Route::controller(CutiController::class)->group(function () {
        Route::get('/cuti-setting', 'index')->name('cuti.index');
        Route::get('/cuti-create', 'create')->name('cuti.create');
        Route::post('/cuti', 'store')->name('cuti.store');
        Route::get('/cuti/{uuid}/edit', 'edit')->name('cuti.edit');
        Route::put('/cuti/{uuid}/update', 'update')->name('cuti.update');
        Route::delete('/cuti', 'destroy')->name('cuti.destroy');
        Route::put('/cuti/approve', 'approve')->name('cuti.approve');
        Route::put('/cuti/reject', 'reject')->name('cuti.reject');

        Route::get('/cuti-saya', 'cuti_saya')->name('cuti.saya');
        Route::get('/cuti-approval', 'approval_page')->name('cuti.approval_page');
        Route::get('/cuti/{uuid}/export-pdf', 'pdf')->name('cuti.pdf');
    });

    // ABSENSI
    Route::controller(AbsensiController::class)->group(function () {
        Route::get('/absensi', 'index')->name('absensi.index');
        Route::get('/my-absensi', 'my_index')->name('absensi.my_index');
        Route::get('/absensi-create', 'create')->name('absensi.create');
        Route::post('/absensi', 'store')->name('absensi.store');
        Route::get('/absensi/{uuid}/edit', 'edit')->name('absensi.edit');
        Route::put('/absensi/{uuid}/update', 'update')->name('absensi.update');
        Route::delete('/absensi', 'destroy')->name('absensi.destroy');
    });

});