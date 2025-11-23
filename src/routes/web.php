<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

// 追加：ルートパスを /login に飛ばす
Route::get('/', function () {
    return redirect('/login');
});

// 勤怠トップページ（ログイン後に見る画面想定）
Route::get('/attendance', [AttendanceController::class, 'index']);
