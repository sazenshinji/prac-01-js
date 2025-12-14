<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T04_GetDateTimeTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_日時取得機能_勤怠登録画面_DateTimeDisplay()
    {
        session(['login_role' => 'user']);

        // ログイン
        $this->post('/login', [
            'email' => '1234@abcd1',
            'password' => '12345678',
        ]);

        $response = $this->get('/attendance');
        $response->assertStatus(200);

        $now = \Carbon\Carbon::now();
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        $weekday = $week[$now->dayOfWeek];

        // ★ 日付部分（全角括弧なし）
        $expectedDate = $now->format("Y年m月d日");

        // ★ 曜日部分（全角括弧あり）
        $expectedWeekday = "（{$weekday}）";

        // ★ Blade は別タグで表示するため、別々にチェックする
        $response->assertSee($expectedDate);
        $response->assertSee($expectedWeekday);

        // 時刻（HH:MM）
        $expectedTime = $now->format("H:i");
        $response->assertSee($expectedTime);
    }
}
