<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T14_AdminStaffListTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_ユーザー情報取得機能（管理者）_StaffListTest()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
        $fixedNow = Carbon::create(2025, 12, 12, 9, 15, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);

        // ================================
        // 案件シート テストケース一覧【58行目】
        // スタッフ一覧画面の確認
        // ================================
        // 管理者ログイン
        $this->withSession(['login_role' => 'admin'])
            ->post('/login', [
                'email' => '1234@abcd5',
                'password' => '12345678',
            ])
            ->assertRedirect('/admin/attendance/list');

        // 勤怠一覧画面（管理者）が表示されていること
        $attendanceList = $this->get('/admin/attendance/list');
        $attendanceList->assertStatus(200);
        $attendanceList->assertSee('勤怠一覧');

        // ヘッダー部の [スタッフ一覧] ボタン押下
        //    → スタッフ一覧画面へ遷移
        $staffList = $this->get('/admin/staff/list');

        // スタッフ一覧画面が表示されていること
        $staffList->assertStatus(200);
        $staffList->assertSee('スタッフ一覧');

        // 表示内容確認（4名分）
        // 大谷 翔平
        $staffList->assertSee('大谷 翔平');
        $staffList->assertSee('1234@abcd1');
        $staffList->assertSee('詳細');
        // 八村 塁
        $staffList->assertSee('八村 塁');
        $staffList->assertSee('1234@abcd2');
        $staffList->assertSee('詳細');
        // 石川 佳純
        $staffList->assertSee('石川 佳純');
        $staffList->assertSee('1234@abcd3');
        $staffList->assertSee('詳細');
        // 渋野 日向子
        $staffList->assertSee('渋野 日向子');
        $staffList->assertSee('1234@abcd4');
        $staffList->assertSee('詳細');

        // 案件シート テストケース一覧【59行目】

        // ================================
        // 案件シート テストケース一覧【59行目】
        // 渋野 日向子 の [詳細] ボタン押下
        // ================================

        // 1. スタッフ別 勤怠一覧画面へ遷移
        //    URL: /admin/attendance/staff/4
        $staffMonthly = $this->get('/admin/attendance/staff/4');
        // 2. 画面が表示されること
        $staffMonthly->assertStatus(200);

        // 3. 表示内容の確認
        // タイトル
        $staffMonthly->assertSee('渋野 日向子さんの勤怠');
        // ナビゲーションバー
        $staffMonthly->assertSee('前月');
        $staffMonthly->assertSee('翌月');
        $staffMonthly->assertSee('2025/12');
        // 日付表示の確認
        $staffMonthly->assertSee('12/01');
        $staffMonthly->assertSee('(月)');
        $staffMonthly->assertSee('12/02');
        $staffMonthly->assertSee('(火)');
        $staffMonthly->assertSee('12/03');
        $staffMonthly->assertSee('(水)');
        $staffMonthly->assertSee('12/04');
        $staffMonthly->assertSee('(木)');
        $staffMonthly->assertSee('12/05');
        $staffMonthly->assertSee('(金)');
        $staffMonthly->assertSee('12/06');
        $staffMonthly->assertSee('(土)');
        $staffMonthly->assertSee('12/30');
        $staffMonthly->assertSee('(火)');
        $staffMonthly->assertSee('12/31');
        $staffMonthly->assertSee('(水)');

        // 勤怠データの確認
        // 12/01 (月)
        $staffMonthly->assertSee('09:01');
        $staffMonthly->assertSee('18:06');
        $staffMonthly->assertSee('1:01');
        $staffMonthly->assertSee('8:04');
        // 12/02 (火)
        $staffMonthly->assertSee('09:02');
        $staffMonthly->assertSee('18:07');
        $staffMonthly->assertSee('1:02');
        $staffMonthly->assertSee('8:03');
        // 12/03 (水)
        $staffMonthly->assertSee('09:03');
        $staffMonthly->assertSee('18:08');
        $staffMonthly->assertSee('1:03');
        $staffMonthly->assertSee('8:02');

        // CSV出力ボタンの確認
        $staffMonthly->assertSee('CSV出力');

        // ================================
        // 案件シート テストケース一覧【60行目】
        // [前月] ボタン押下
        // ================================
        // [前月] ボタン押下（2025-11）
        $staffMonthlyPrev = $this->get('/admin/attendance/staff/4?month=2025-11');
        // 画面が表示されること
        $staffMonthlyPrev->assertStatus(200);

        // 表示月の確認
        $staffMonthlyPrev->assertSee('2025/11');

        // 日付表示の確認（改行対策で分割チェック）
        $staffMonthlyPrev->assertSee('11/01');
        $staffMonthlyPrev->assertSee('(土)');

        $staffMonthlyPrev->assertSee('11/02');
        $staffMonthlyPrev->assertSee('(日)');

        $staffMonthlyPrev->assertSee('11/30');
        $staffMonthlyPrev->assertSee('(日)');

        // 勤怠データの確認
        // 11/25 (火)
        $staffMonthlyPrev->assertSee('11/25');
        $staffMonthlyPrev->assertSee('(火)');
        $staffMonthlyPrev->assertSee('09:00');
        $staffMonthlyPrev->assertSee('18:00');
        $staffMonthlyPrev->assertSee('0:00');
        $staffMonthlyPrev->assertSee('9:00');
        // 11/26 (火)
        $staffMonthlyPrev->assertSee('11/26');
        $staffMonthlyPrev->assertSee('(火)');
        $staffMonthlyPrev->assertSee('09:00');
        $staffMonthlyPrev->assertSee('18:00');
        $staffMonthlyPrev->assertSee('0:00');
        $staffMonthlyPrev->assertSee('9:00');
        // 11/27 (火)
        $staffMonthlyPrev->assertSee('11/27');
        $staffMonthlyPrev->assertSee('(火)');
        $staffMonthlyPrev->assertSee('09:00');
        $staffMonthlyPrev->assertSee('18:00');
        $staffMonthlyPrev->assertSee('0:00');
        $staffMonthlyPrev->assertSee('9:00');
        // 11/28 (火)
        $staffMonthlyPrev->assertSee('11/28');
        $staffMonthlyPrev->assertSee('(火)');
        $staffMonthlyPrev->assertSee('09:00');
        $staffMonthlyPrev->assertSee('18:00');
        $staffMonthlyPrev->assertSee('0:00');
        $staffMonthlyPrev->assertSee('9:00');

        // ================================
        // 案件シート テストケース一覧【61行目】
        // [翌月] ボタン押下
        // ================================
        $staffMonthlyNext = $this->get('/admin/attendance/staff/4?month=2025-12');
        // 画面が表示されること
        $staffMonthlyNext->assertStatus(200);

        // 表示月の確認
        $staffMonthlyNext->assertSee('2025/12');

        // 日付表示の確認（改行対策で分割チェック）
        $staffMonthlyNext->assertSee('12/01');
        $staffMonthlyNext->assertSee('(月)');
        $staffMonthlyNext->assertSee('12/02');
        $staffMonthlyNext->assertSee('(火)');
        $staffMonthlyNext->assertSee('12/31');
        $staffMonthlyNext->assertSee('(水)');

        // 勤怠データの確認
        // 12/01 (月)
        $staffMonthlyNext->assertSee('09:01');
        $staffMonthlyNext->assertSee('18:06');
        $staffMonthlyNext->assertSee('1:01');
        $staffMonthlyNext->assertSee('8:04');
        // 12/02 (火)
        $staffMonthlyNext->assertSee('09:02');
        $staffMonthlyNext->assertSee('18:07');
        $staffMonthlyNext->assertSee('1:02');
        $staffMonthlyNext->assertSee('8:03');

        // ログアウト（管理者）
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }

    public function test_ユーザー情報取得機能（管理者）_DateilDisplayTest()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
        $fixedNow = Carbon::create(2025, 12, 5, 9, 15, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);

        // ================================
        // 案件シート テストケース一覧【62行目】
        // 勤怠詳細画面への遷移の確認
        // ================================
        // 管理者ログイン
        $this->withSession(['login_role' => 'admin'])
            ->post('/login', [
                'email' => '1234@abcd5',
                'password' => '12345678',
            ])
            ->assertRedirect('/admin/attendance/list');
        // 勤怠一覧画面（管理者・指定日）
        $response = $this->get('/admin/attendance/list?date=2025-12-05');
        // ステータス確認
        $response->assertStatus(200);

        // 大谷 翔平 の [詳細] ボタン押下（管理者）
        // 勤怠詳細画面へ遷移
        $detail = $this->get('/admin/attendance/1/2025-12-05');
        // ステータス確認
        $detail->assertStatus(200);
        // URL 遷移確認（明示）
        $detail->assertSee('勤怠詳細');
        // 表示内容確認
        // 名前
        $detail->assertSee('大谷 翔平');
        // 日付
        $detail->assertSee('2025年');
        $detail->assertSee('12月');
        $detail->assertSee('5日');
        // 出勤・退勤
        $detail->assertSee('09:00');
        $detail->assertSee('18:00');
        // 休憩
        $detail->assertSee('12:00');
        $detail->assertSee('13:00');

        // ログアウト（管理者）
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
