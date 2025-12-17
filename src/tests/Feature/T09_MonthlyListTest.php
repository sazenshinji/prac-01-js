<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T09_MonthlyListTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    // 渋野 日向子
    private $email = '1234@abcd4';
    private $password = '12345678';

    public function test_勤怠一覧情報取得機能（一般ユーザー）_勤怠情報確認_勤怠一覧画面()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
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
        // 勤怠一覧へ遷移
        $list = $this->get('/attendance/list');
        $list->assertStatus(200);

        // ================================
        // 勤怠一覧（Seedingデータ3日分）の表示確認
        // ================================
        // 12/01 (月)
        $list->assertSee('12/01');
        $list->assertSee('(月)');
        $list->assertSee('09:01'); // 出勤
        $list->assertSee('18:06'); // 退勤
        $list->assertSee('1:01');  // 休憩
        $list->assertSee('8:04');  // 合計
        $list->assertSee('attendance/detail/2025-12-01', false);
        // 12/02 (火)
        $list->assertSee('12/02');
        $list->assertSee('(火)');
        $list->assertSee('09:02');
        $list->assertSee('18:07');
        $list->assertSee('1:02');
        $list->assertSee('8:03');
        $list->assertSee('attendance/detail/2025-12-02', false);
        // 12/03 (水)
        $list->assertSee('12/03');
        $list->assertSee('(水)');
        $list->assertSee('09:03');
        $list->assertSee('18:08');
        $list->assertSee('1:03');
        $list->assertSee('8:02');
        $list->assertSee('attendance/detail/2025-12-03', false);

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }

    public function test_勤怠一覧情報取得機能（一般ユーザー）_月表示月切替確認_勤怠一覧画面()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
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
        // 勤怠一覧へ遷移
        $list = $this->get('/attendance/list');
        $list->assertStatus(200);

        // 月表示・月切替の確認
        // 初期表示：2025/12
        $list->assertSee('2025/12');
        // 前月ボタン → 2025/11
        $prevMonth = $this->get('/attendance/list?month=2025-11');
        $prevMonth->assertStatus(200);
        $prevMonth->assertSee('2025/11');
        // 翌月ボタンを2回 → 2026/01
        $nextMonth = $this->get('/attendance/list?month=2026-01');
        $nextMonth->assertStatus(200);
        $nextMonth->assertSee('2026/01');

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }

    public function test_勤怠一覧情報取得機能（一般ユーザー）_詳細画面遷移確認()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
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
        // 勤怠一覧へ遷移
        $list = $this->get('/attendance/list');
        $list->assertStatus(200);

        // 12/01 (月) の [詳細] ボタン遷移確認
        // 詳細画面へ直接遷移（= 詳細ボタン押下と同義）
        $detail = $this->get('/attendance/detail/2025-12-01');
        $detail->assertStatus(200);
        // URLが正しいこと
        $detail->assertSee('2025-12-01');
        // 画面タイトル（勤怠詳細）が表示されていること
        $detail->assertSee('勤怠詳細');

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
