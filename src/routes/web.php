<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LogoutController;

// 未ログインはログイン画面へ
Route::get('/', fn() => redirect('/login'));

// 管理者ログイン画面
Route::middleware('guest')->get('/admin/login', function () {
    session(['login_role' => 'admin']);
    return view('auth.adminlogin');
})->name('admin.login');

// 一般ユーザー向けページ
Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');

    // 打刻用ルート
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');
    Route::post('/attendance/break-in', [AttendanceController::class, 'breakIn'])->name('attendance.breakIn');
    Route::post('/attendance/break-out', [AttendanceController::class, 'breakOut'])->name('attendance.breakOut');

    // 勤怠一覧(ユーザー)
    Route::get('/attendance/list', [AttendanceController::class, 'list'])->name('attendance.list');
});

// 管理者専用ページ
Route::middleware(['auth', 'admin'])->get('/admin/attendance/list', fn() => view('admin.daily'))->name('admin.daily');

// ログアウト（共通）
Route::post('/logout', LogoutController::class)->name('logout');
