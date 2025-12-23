<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T15_AdminDetailCorrectionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_勤怠情報修正機能（管理者）_RequestListTest()
    {
        // テスト時刻を固定（Seedingデーターと合わせるため）
        $fixedNow = Carbon::create(2025, 12, 12, 9, 15, 0, 'Asia/Tokyo');
        Carbon::setTestNow($fixedNow);

        // ================================
        // 案件シート テストケース一覧【63行目】
        // 承認待ち申請表示の確認
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
        // 管理者ヘッダーの[申請一覧]ボタン押下
        $response = $this->get('/stamp_correction_request/list');
        // 申請一覧画面が表示され、承認待ちタブであること
        $response->assertStatus(200);
        $response->assertSee('申請一覧');
        $response->assertSee('承認待ち');

        // 承認待ち申請 5件の表示確認
        // 大谷 翔平 / 2025-11-05 / 間違い修正
        $response->assertSee('承認待ち');
        $response->assertSee('大谷 翔平');
        $response->assertSee('2025/11/05');
        $response->assertSee('間違い修正');
        // 大谷 翔平 / 2025-11-08 / 後日入力
        $response->assertSee('承認待ち');
        $response->assertSee('大谷 翔平');
        $response->assertSee('2025/11/08');
        $response->assertSee('後日入力');
        // 大谷 翔平 / 2025-12-01 / 入力ミス
        $response->assertSee('承認待ち');
        $response->assertSee('大谷 翔平');
        $response->assertSee('2025/12/01');
        $response->assertSee('入力ミス');
        // 八村 塁 / 2025-11-28 / 八村 塁、修正
        $response->assertSee('承認待ち');
        $response->assertSee('八村 塁');
        $response->assertSee('2025/11/28');
        $response->assertSee('八村 塁、修正');
        // 石川 佳純 / 2025-11-30 / 石川 佳純、後日入力
        $response->assertSee('承認待ち');
        $response->assertSee('石川 佳純');
        $response->assertSee('2025/11/30');
        $response->assertSee('石川 佳純、後日入力');

        // ================================
        // 案件シート テストケース一覧【64行目】
        // 承認済み申請表示の確認
        // ================================
        // 「承認済み」タブへ切り替え
        $approvedResponse = $this->get('/stamp_correction_request/list?tab=approved');

        // 申請一覧画面が表示されていること
        $approvedResponse->assertStatus(200);
        $approvedResponse->assertSee('申請一覧');
        $approvedResponse->assertSee('承認済み');

        // 承認済み申請 2件の表示確認
        // 大谷 翔平 / 2025-12-02 / 修正(代：長嶋茂雄)
        $approvedResponse->assertSee('承認済み');
        $approvedResponse->assertSee('大谷 翔平');
        $approvedResponse->assertSee('2025/12/02');
        $approvedResponse->assertSee('修正(代：長嶋茂雄)');
        // 渋野 日向子 / 2025-12-01 / 修正(代：長嶋茂雄)
        $approvedResponse->assertSee('承認済み');
        $approvedResponse->assertSee('渋野 日向子');
        $approvedResponse->assertSee('2025/12/01');
        $approvedResponse->assertSee('修正(代：長嶋茂雄)');

        // ================================
        // 案件シート テストケース一覧【65行目】
        // 承認待ち申請－詳細表示の確認
        // ================================
        // 1. 「承認待ち」タブへ切り替え
        $pendingResponse = $this->get('/stamp_correction_request/list?tab=pending');
        $pendingResponse->assertStatus(200);
        $pendingResponse->assertSee('申請一覧');
        $pendingResponse->assertSee('承認待ち');
        // 2. 八村 塁 / 2025-11-28 の [詳細] ボタン押下
        //    → 修正申請ID = 5（Seeder前提）
        $detailResponse = $this->get('/stamp_correction_request/approve/5');
        // 3. 修正申請承認画面が表示されること
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('勤怠詳細');
        // 4. 表示内容の確認
        // 名前
        $detailResponse->assertSee('八村 塁');
        // 日付
        $detailResponse->assertSee('2025年');
        $detailResponse->assertSee('11月');
        $detailResponse->assertSee('28日');
        // 出勤・退勤
        $detailResponse->assertSee('09:30');
        $detailResponse->assertSee('18:30');
        // 休憩
        $detailResponse->assertSee('12:05');
        $detailResponse->assertSee('13:06');
        // 備考
        $detailResponse->assertSee('八村 塁、修正');
        // 5. [承認]ボタンが表示されていること
        $detailResponse->assertSee('承認');

        // ================================
        // 案件シート テストケース一覧【66行目】
        // 承認処理の確認
        // ================================
        // 1. [承認]ボタン押下
        $approveResponse = $this->post(
            route('admin.request.approve', ['id' => 5])
        );
        // 承認後は詳細画面へリダイレクト
        $approveResponse->assertRedirect(
            route('request.detail', ['id' => 5])
        );
        // 2. 再表示された画面で、ボタンが「承認済み」に変わることを確認
        $afterApprovePage = $this->get(
            route('request.detail', ['id' => 5])
        );
        $afterApprovePage->assertStatus(200);
        $afterApprovePage->assertSee('承認済み');

        // 3. 勤怠情報の更新(attendances テーブル)の確認
        $this->assertDatabaseHas('attendances', [
            'user_id'   => 2,
            'work_date' => '2025-11-28',
            'clock_in'  => '2025-11-28 09:30:00',
            'clock_out' => '2025-11-28 18:30:00',
            'status'    => 3, // 退勤済
        ]);
        // 4. breaktimes テーブルの確認
        $this->assertDatabaseHas('breaktimes', [
            'attendance_id' => 28,
            'break_index'   => 1,
            'break_start'   => '2025-11-28 12:05:00',
            'break_end'     => '2025-11-28 13:06:00',
        ]);
        // ログアウト（管理者）
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
