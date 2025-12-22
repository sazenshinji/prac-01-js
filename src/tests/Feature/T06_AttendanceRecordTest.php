<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T06_AttendanceRecordTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    private $email = '1234@abcd1';
    private $password = '12345678';

    public function test_出勤機能_出勤ボタン_勤怠登録画面()
    {
        /**
         * 出勤ボタンが正しく機能する
         */
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
        // ステータスが「勤務外」を確認
        $page->assertSee("勤務外");
        // ★「出勤」ボタンが表示されていることを確認
        $page->assertSee('出勤');
        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');
        // 画面を再取得する
        $page = $this->get('/attendance');
        // ★ ステータス「出勤中」か確認
        $page->assertSee("出勤中");
        // 退勤ボタン押下
        $this->post('/attendance/clock-out')->assertRedirect('/attendance');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();


        /**
         * 出勤は一日一回のみできる
         */
        // ログイン
        $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ])->assertRedirect('/attendance');

        // 勤怠登録画面表示確認
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ステータスが退勤済を確認
        $page->assertSee("退勤済");
        // ★ 勤怠ボタンが表示されていないことを確認
        $page->assertDontSee('>出勤<', false);
        $page->assertDontSee('>退勤<', false);
        $page->assertDontSee('>休憩入<', false);
        $page->assertDontSee('>休憩戻<', false);
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }


    public function test_出勤機能_打刻時刻確認_勤怠一覧画面()
    {
        /**
         * 出勤時刻が勤怠一覧画面で確認できる
         */

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
        //　勤怠登録画面表示確認
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');
        // ヘッダーに「勤怠一覧」リンクがあること
        $page->assertSee('href="http://localhost/attendance/list"', false);
        // 「勤怠一覧」へ遷移（ヘッダーボタン押下）
        $list = $this->get('/attendance/list');
        $list->assertStatus(200);
        // 本日の日付が「MM/DD（曜）」形式で表示されていること
        $weekday = ['日', '月', '火', '水', '木', '金', '土'][$fixedNow->dayOfWeek];
        // ★ 日付（m/d）確認
        $list->assertSee($fixedNow->format('m/d'));
        // ★（曜）確認
        $list->assertSee('(' . $weekday . ')');
        // ★ 本日の行に、打刻した出勤時刻が「HH:MM」で表示されていること
        $list->assertSee($fixedNow->format('H:i'));
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
