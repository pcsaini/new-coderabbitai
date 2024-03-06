<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', 'home');

Route::prefix('auth')->middleware('guest')->group(function () {
    Route::redirect('auth', 'auth/login');

    Route::view('login', 'pages.auth.login')->name('auth.login');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login.post');

    Route::view('register', 'pages.auth.register')->name('auth.register');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::view('deposit', 'pages.deposit')->name('deposit');
    Route::post('deposit', [PaymentController::class, 'deposit'])->name('deposit.post');

    Route::view('withdraw', 'pages.withdraw')->name('withdraw');
    Route::post('withdraw', [PaymentController::class, 'withdraw'])->name('withdraw.post');

    Route::view('transfer', 'pages.transfer')->name('transfer');
    Route::post('transfer', [PaymentController::class, 'transfer'])->name('transfer.post');

    Route::get('statement', [PaymentController::class, 'statement'])->name('statement');

    Route::any('logout', [AuthController::class, 'logout'])->name('auth.logout');
});

