<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\data_essentials\RoleController;
use App\Http\Controllers\data_essentials\SeksiController;
use App\Http\Controllers\data_essentials\ProvinsiController;
use App\Http\Controllers\data_essentials\RoleUserController;
use App\Http\Controllers\data_essentials\UnitKerjaController;
use App\Http\Controllers\data_essentials\WalikotaController;

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
        // Mockup Pulau Titip di Controller Da`shboard
        Route::get('/pulau', 'pulau')->name('pulau.index');
    });

    // ---------------------MASTERDATA ESSENTIALS----------------------------

    Route::controller(ProvinsiController::class)->group(function () {
        Route::get('/provinsi', 'index')->name('provinsi.index');
        Route::get('/provinsi-create', 'create')->name('provinsi.create');
        Route::post('/provinsi-store', 'store')->name('provinsi.store');
        Route::get('/provinsi-show/{uuid}', 'show')->name('provinsi.show');
        Route::put('/provinsi-update/{uuid}', 'update')->name('provinsi.update');
        Route::delete('/provinsi-delete', 'destroy')->name('provinsi.destroy');
    });

    Route::controller(WalikotaController::class)->group(function () {
        Route::get('/walikota', 'index')->name('walikota.index');
        Route::get('/walikota-create', 'create')->name('walikota.create');
        Route::post('/walikota-store', 'store')->name('walikota.store');
        Route::get('/walikota-show/{uuid}', 'show')->name('walikota.show');
        Route::put('/walikota-update/{uuid}', 'update')->name('walikota.update');
        Route::delete('/walikota-delete', 'destroy')->name('walikota.destroy');
    });

    Route::controller(UnitKerjaController::class)->group(function () {
        Route::get('/unitkerja', 'index')->name('unitkerja.index');
        Route::get('/unitkerja-create', 'create')->name('unitkerja.create');
        Route::post('/unitkerja-store', 'store')->name('unitkerja.store');
        Route::get('/unitkerja-show/{uuid}', 'show')->name('unitkerja.show');
        Route::put('/unitkerja-update/{uuid}', 'update')->name('unitkerja.update');
        Route::delete('/unitkerja-delete', 'destroy')->name('unitkerja.destroy');
    });

    Route::controller(SeksiController::class)->group(function () {
        Route::get('/seksi', 'index')->name('seksi.index');
        Route::get('/seksi-create', 'create')->name('seksi.create');
        Route::post('/seksi-store', 'store')->name('seksi.store');
        Route::get('/seksi-show/{uuid}', 'show')->name('seksi.show');
        Route::put('/seksi-update/{uuid}', 'update')->name('seksi.update');
        Route::delete('/seksi-delete', 'destroy')->name('seksi.destroy');
    });

    Route::controller(RoleController::class)->group(function () {
        Route::get('/role', 'index')->name('role.index');
        Route::get('/role-create', 'create')->name('role.create');
        Route::post('/role-store', 'store')->name('role.store');
        Route::get('/role-show/{uuid}', 'show')->name('role.show');
        Route::put('/role-update/{uuid}', 'update')->name('role.update');
        Route::delete('/role-delete', 'destroy')->name('role.destroy');
    });

    Route::controller(RoleUserController::class)->group(function () {
        Route::get('/role-user', 'index')->name('role_user.index');
        Route::get('/role-user/create', 'create')->name('role_user.create');
        Route::post('/role-user', 'store')->name('role_user.store');
        Route::get('/role-user/{uuid}/edit', 'edit')->name('role_user.edit');
        Route::put('/role-user/{uuid}/update', 'update')->name('role_user.update');
        Route::delete('/role-user', 'destroy')->name('role_user.destroy');
    });

});