<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', [\App\Http\Controllers\LoginController::class, 'logout']);
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::view('/change-pass', 'change-pass')->name('change.pass');

Route::group(['middleware' => 'logged.in'], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name("home");

    Route::get('/login/{as?}', [\App\Http\Controllers\WelcomeController::class, 'index'])->name('login');
    Route::post('/do-login', [\App\Http\Controllers\LoginController::class, 'login'])->name('do.login');
});

Route::prefix("admin")->group(function () {
    Route::group(['middleware' => 'auth'], function () {
        Route::get("/", [\App\Http\Controllers\DashboardController::class, 'index']);
        Route::view("/kelas", 'admin.master-kelas');
        Route::view("/unit", "admin.master-unit");
        Route::view("/kategory-keuangan", 'admin.master-kategory-keuangan');
        Route::view("/siswa", 'admin.master-siswa');
        Route::view("/pembayaran", 'admin.trx-pembayaran');
        Route::get("/pembayaran/print-pdf/{idMurid}/{tglBayar}", [\App\Http\Controllers\PembayaranController::class, 'printPdf'])->name("pembayaran.print.pdf");
    });
});

Route::prefix("operator")->group(function () {
//    Route::get("/", function () {
//        return view('operator.dashboard');
//    });
    Route::view("/pembayaran", 'admin.trx-pembayaran');
});

Route::prefix("siswa")->group(function () {
    Route::view("/", 'siswa.dashboard');
    Route::view("/transaksi", 'siswa.transaksi');
});
