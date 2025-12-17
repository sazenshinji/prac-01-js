<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T04_GetDateTimeTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_日時取得機能_DateTimeDisplay_勤怠登録画面()
    {
        // Fortify の login_role（一般ユーザー想定）をセット
        session(['login_role' => 'user']);
        // ログイン
        $this->post('/login', [
            'email' => '1234@abcd1',
            'password' => '12345678',
        ]);
        // 勤怠登録画面へ遷移しているか。
        $response = $this->get('/attendance');
        $response->assertStatus(200);

        $now = \Carbon\Carbon::now();
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        $weekday = $week[$now->dayOfWeek];

        // 日付部分
        $expectedDate = $now->format("Y年m月d日");
        // 曜日部分（全角括弧あり）
        $expectedWeekday = "（{$weekday}）";
        // ★ 年月日（曜）表示のチェックチェックする
        $response->assertSee($expectedDate);
        $response->assertSee($expectedWeekday);
        // ★ 時刻（HH:MM）表示のチェック
        $expectedTime = $now->format("H:i");
        $response->assertSee($expectedTime);
    }
}
