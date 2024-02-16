<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SeksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\data_essentials\ProvinsiController;
use App\Http\Controllers\data_essentials\UnitKerjaController;
use App\Http\Controllers\data_essentials\WalikotaController;


Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'login')->name('login.index');
});

// ---------------------DASHBOARDCONTROLLER----------------------------

Route::controller(DashboardController::class)->group(function () {
    // Mainmenu
    Route::get('/dashboard', 'index')->name('dashboard.index');
    // Data Essentials
    Route::get('/data_essentials', 'data_essentials')->name('data_essentials.index');
    // Data Assets
    Route::get('/data_assets', 'data_assets')->name('data_assets.index');
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


