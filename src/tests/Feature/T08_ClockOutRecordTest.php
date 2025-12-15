<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;


class T08_ClockOutRecordTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    private $email = '1234@abcd1';
    private $password = '12345678';

    public function test_退勤機能_退勤ボタン_勤怠登録画面()
    {
        // ログイン（セッションに login_role をセット）
        $response = $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ]);
        $response->assertRedirect('/attendance');
        // 勤怠登録画面表示確認
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');
        // 「出勤中」の状態で一旦ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        // 「出勤中」の状態で再度ログイン
        $response = $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ]);
        // 勤怠登録画面表示確認
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ 退勤ボタンが表示されていることを確認
        $page->assertSee('退勤');
        // 退勤ボタン押下
        $this->post('/attendance/clock-out')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ ステータスが「退勤済」になっていることを確認
        $page->assertSee('退勤済');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_退勤機能_退勤時刻記録_勤怠一覧()
    {
        // テスト時刻を固定（ブレ防止）
        $fixedNow = Carbon::create(2025, 12, 12, 9, 15, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);

        // ログイン（セッションに login_role をセット）
        $response = $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ]);
        $response->assertRedirect('/attendance');
        // 勤怠登録画面表示確認
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // テータスが「勤務外」を確認
        $page->assertSee("勤務外");
        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');

        // テスト時刻を9時間21分進める
        $fixedNow = Carbon::create(2025, 12, 12, 18, 36, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 退勤ボタン押下
        $this->post('/attendance/clock-out')->assertRedirect('/attendance');

        // 勤怠一覧へ遷移
        $list = $this->get('/attendance/list');
        $list->assertStatus(200);
        // 曜日取得
        $weekday = ['日', '月', '火', '水', '木', '金', '土'][$fixedNow->dayOfWeek];
        // 本日の日付が「MM/DD（曜）」形式で表示されていること
        $list->assertSee($fixedNow->format('m/d'));
        $list->assertSee('(' . $weekday . ')');
        // 出勤時刻「09:15」が表示されていること
        $list->assertSee('09:15');
        // ★ 退勤時刻「18:36」が表示されていること
        $list->assertSee('18:36');
        // 合計時間「9:21」が表示されていること
        $list->assertSee('9:21');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
