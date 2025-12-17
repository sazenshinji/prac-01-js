<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T12_AdminTodayListTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    // 案件シート テストケース一覧【49,50,51,52行目】
    public function test_勤怠一覧情報取得機能（管理者）_勤怠一覧画面()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
        $fixedNow = Carbon::create(2025, 12, 12, 9, 15, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);

        // 管理者ログイン
        $this->withSession(['login_role' => 'admin'])
            ->post('/login', [
                'email' => '1234@abcd5',
                'password' => '12345678',
            ])
            ->assertRedirect('/admin/attendance/list');
        // 勤怠一覧画面（管理者・指定日）
        $response = $this->get('/admin/attendance/list?date=2025-12-02');
        // ステータス確認
        $response->assertStatus(200);

        // 表示内容確認（4名分）
        // 大谷 翔平
        $response->assertSee('大谷 翔平');
        $response->assertSee('07:00');
        $response->assertSee('21:00');
        $response->assertSee('1:45');
        $response->assertSee('12:15');
        // 八村 塁
        $response->assertSee('八村 塁');
        $response->assertSee('09:00');
        $response->assertSee('18:00');
        $response->assertSee('0:00');
        $response->assertSee('9:00');
        // 石川 佳純
        $response->assertSee('石川 佳純');
        $response->assertSee('09:00');
        $response->assertSee('18:00');
        $response->assertSee('0:00');
        $response->assertSee('9:00');
        // 渋野 日向子
        $response->assertSee('渋野 日向子');
        $response->assertSee('09:02');
        $response->assertSee('18:07');
        $response->assertSee('1:02');
        $response->assertSee('8:03');

        // 今日の日付が表示されていること
        $response->assertSee('2025/12/02');

        // 前日ボタン押下（2025-12-01）
        $prevResponse = $this->get('/admin/attendance/list?date=2025-12-01');
        // ステータス確認
        $prevResponse->assertStatus(200);
        // 日付表示確認
        $prevResponse->assertSee('2025年12月1日');
        $prevResponse->assertSee('2025/12/01');

        // 表示内容確認（前日・4名分）
        // 大谷 翔平
        $prevResponse->assertSee('大谷 翔平');
        $prevResponse->assertSee('09:00');
        $prevResponse->assertSee('18:00');
        $prevResponse->assertSee('1:00');
        $prevResponse->assertSee('8:00');
        // 八村 塁
        $prevResponse->assertSee('八村 塁');
        $prevResponse->assertSee('09:00');
        $prevResponse->assertSee('18:00');
        $prevResponse->assertSee('0:00');
        $prevResponse->assertSee('9:00');
        // 石川 佳純
        $prevResponse->assertSee('石川 佳純');
        $prevResponse->assertSee('09:00');
        $prevResponse->assertSee('18:00');
        $prevResponse->assertSee('0:00');
        $prevResponse->assertSee('9:00');
        // 渋野 日向子
        $prevResponse->assertSee('渋野 日向子');
        $prevResponse->assertSee('09:01');
        $prevResponse->assertSee('18:06');
        $prevResponse->assertSee('1:01');
        $prevResponse->assertSee('8:04');

        // 翌日ボタンを2回押下（2025-12-03）
        $nextResponse = $this->get('/admin/attendance/list?date=2025-12-03');
        // ステータス確認
        $nextResponse->assertStatus(200);
        // 日付表示確認
        $nextResponse->assertSee('2025年12月3日');
        $nextResponse->assertSee('2025/12/03');

        // 表示内容確認（翌日・4名分）
        // 大谷 翔平
        $nextResponse->assertSee('大谷 翔平');
        $nextResponse->assertSee('09:00');
        $nextResponse->assertSee('18:00');
        $nextResponse->assertSee('1:10');
        $nextResponse->assertSee('7:50');
        // 八村 塁
        $nextResponse->assertSee('八村 塁');
        $nextResponse->assertSee('09:00');
        $nextResponse->assertSee('18:00');
        $nextResponse->assertSee('0:00');
        $nextResponse->assertSee('9:00');
        // 石川 佳純
        $nextResponse->assertSee('石川 佳純');
        $nextResponse->assertSee('09:00');
        $nextResponse->assertSee('18:00');
        $nextResponse->assertSee('0:00');
        $nextResponse->assertSee('9:00');
        // 渋野 日向子
        $nextResponse->assertSee('渋野 日向子');
        $nextResponse->assertSee('09:03');
        $nextResponse->assertSee('18:08');
        $nextResponse->assertSee('1:03');
        $nextResponse->assertSee('8:02');

        // ログアウト（管理者）
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
