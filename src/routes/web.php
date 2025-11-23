<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LogoutController;

// 一般ユーザー向け
Route::middleware(['auth'])->get('/attendance', [AttendanceController::class, 'index'])->name('attendance');

// 管理者ログイン画面
Route::get('/admin/login', fn() => view('auth.adminlogin'))->name('admin.login');

// 管理者専用画面（auth + admin）
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/attendance/list', fn() => view('admin.daily'))->name('admin.daily');
});

// ログアウト処理
Route::post('/logout', LogoutController::class)->name('logout');

// 未ログインはログインへ
Route::get('/', fn() => redirect('/login'));
