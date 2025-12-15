<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T07_BreakRecordTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    private $email = '1234@abcd1';
    private $password = '12345678';

    public function test_休憩機能_休憩入ボタン_勤怠登録画面()
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
        // ★ 「休憩入」ボタンが表示されていることを確認
        $page->assertSee('休憩入');
        // 休憩入ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ ステータスが「休憩中」に変わっていることを確認
        $page->assertSee('休憩中');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_休憩機能_二回目の休憩入ボタン_勤怠登録画面()
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
        // 「休憩入」ボタンが表示されていることを確認
        $page->assertSee('休憩入');
        // 休憩入ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 「休憩戻」ボタンが表示されていることを確認
        $page->assertSee('休憩戻');
        // 休憩戻ボタン押下
        $this->post('/attendance/break-out')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ 再び「休憩入」ボタンが表示されていることを確認（2回目の休憩が可能）
        $page->assertSee('休憩入');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_休憩機能_二回目の休憩前のステータス_勤怠登録画面()
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
        // 「休憩入」ボタンが表示されていることを確認
        $page->assertSee('休憩入');
        // 休憩入ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 「休憩戻」ボタンが表示されていることを確認
        $page->assertSee('休憩戻');
        // 休憩戻ボタン押下
        $this->post('/attendance/break-out')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ ステータスが「出勤中」にかわることを確認する
        $page->assertSee("出勤中");
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_休憩機能_二回目の休憩戻ボタン_勤怠登録画面()
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
        // 「休憩入」ボタンが表示されていることを確認
        $page->assertSee('休憩入');
        // 休憩入ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 「休憩戻」ボタンが表示されていることを確認
        $page->assertSee('休憩戻');
        // 休憩戻ボタン押下
        $this->post('/attendance/break-out')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 再び「休憩入」ボタンが表示されていることを確認（2回目の休憩が可能）
        $page->assertSee('休憩入');
        // 2回目の「休憩入」ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ 二回目の「休憩戻」ボタンが表示されていることを確認
        $page->assertSee('休憩戻');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }

    public function test_休憩機能_休憩時刻確認_勤怠一覧、詳細画面()
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
        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 休憩入ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');

        // テスト時刻を1時間15分進める
        $fixedNow = Carbon::create(2025, 12, 12, 10, 30, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);
        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // 休憩戻ボタン押下
        $this->post('/attendance/break-out')->assertRedirect('/attendance');
        // 退勤ボタン押下
        $this->post('/attendance/clock-out')->assertRedirect('/attendance');

        // 勤怠一覧へ遷移
        $list = $this->get('/attendance/list');
        $list->assertStatus(200);
        // 本日の日付が「MM/DD（曜）」形式で表示されていること
        $weekday = ['日', '月', '火', '水', '木', '金', '土'][$fixedNow->dayOfWeek];
        $list->assertSee($fixedNow->format('m/d'));
        $list->assertSee('(' . $weekday . ')');
        // ★ 休憩時間「01:15」が表示されていること
        $list->assertSee('1:15');

        // 勤怠詳細画面での確認
        $date = $fixedNow->format('Y-m-d');
        // 勤怠詳細画面へ遷移
        $detail = $this->get('/attendance/detail/' . $date);
        $detail->assertStatus(200);
        // ★ 休憩入・休憩戻の時刻が表示されていること
        $detail->assertSee('09:15');
        $detail->assertSee('10:30');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
