<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AttendanceController as UserAttendanceController;
use App\Http\Controllers\Admin\ConfirmController as AdminConfirmController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Common_display\DisplayController;

// 未ログインはログイン画面へ
Route::get('/', fn() => redirect('/login'));

// 管理者ログイン画面
Route::middleware('guest')->get('/admin/login', function () {
    session(['login_role' => 'admin']);
    return view('auth.adminlogin');
})->name('admin.login');

// 一般ユーザー向けページ
Route::middleware(['auth', 'verified'])
    ->prefix('attendance')
    ->group(function () {

        // 勤怠ホーム（打刻画面）
        Route::get('/', [UserAttendanceController::class, 'index'])->name('attendance');

        // 打刻用ルート
        Route::post('/clock-in', [UserAttendanceController::class, 'clockIn'])->name('attendance.clockIn');
        Route::post('/clock-out', [UserAttendanceController::class, 'clockOut'])->name('attendance.clockOut');
        Route::post('/break-in', [UserAttendanceController::class, 'breakIn'])->name('attendance.breakIn');
        Route::post('/break-out', [UserAttendanceController::class, 'breakOut'])->name('attendance.breakOut');

        // 月次勤怠一覧表示
        Route::get('/list', [DisplayController::class, 'monthly'])->name('attendance.list');

        // 勤怠詳細画面（一般ユーザー）
        Route::get('/detail/{date}', [DisplayController::class, 'detail'])
            ->name('attendance.detail');

        // 【追加】修正申請（POST）
        Route::post('/detail/update', [DisplayController::class, 'update'])
            ->name('attendance.detail.update');

        // 【追加】削除申請（POST）
        Route::post('/detail/delete', [DisplayController::class, 'delete'])
            ->name('attendance.detail.delete');
    });

//  申請一覧（一般ユーザー） 
Route::middleware(['auth', 'verified'])
    ->get('/stamp_correction_request/list', [DisplayController::class, 'requestList'])
    ->name('request.list');

// 管理者専用ページ
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // 日次勤怠一覧
        Route::get('/attendance/list', [AdminConfirmController::class, 'daily'])
            ->name('daily');

        // 管理者用 勤怠詳細表示
        Route::get('/attendance/{user}/{date}', [DisplayController::class, 'adminDetail'])
            ->name('attendance.detail');
    });

// ログアウト（共通）
Route::post('/logout', LogoutController::class)->name('logout');
