<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;


class T13_AdminDetailDisplayTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    // 案件シート テストケース一覧【53-57行目】
    public function test_勤怠詳細情報取得・修正機能（管理者）_バリデーション()
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

        // ================================
        // ケース-1-1 出勤 19:00 / 退勤 18:00
        // ================================
        $response = $this->post(
            route('admin.attendance.immediateUpdate', [
                'user' => 1,
                'date' => '2025-12-05',
            ]),
            [
                'clock_in'  => '19:00',
                'clock_out' => '18:00',
            ]
        );
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/admin/attendance/1/2025-12-05');
        // 再表示された詳細画面にエラーメッセージが出る
        $errorPage = $this->get('/admin/attendance/1/2025-12-05');
        $errorPage->assertSee('出勤時間もしくは退勤時間が不適切な値です');

        // ================================
        // ケース-1-2 出勤 09:00 / 退勤 08:00
        // (出勤、退勤が逆転)
        // ================================
        $response = $this->post(
            route('admin.attendance.immediateUpdate', [
                'user' => 1,
                'date' => '2025-12-05',
            ]),
            [
                'clock_in'  => '9:00',
                'clock_out' => '8:00',
            ]
        );
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/admin/attendance/1/2025-12-05');
        // 再表示された詳細画面にエラーメッセージが出る
        $errorPage = $this->get('/admin/attendance/1/2025-12-05');
        $errorPage->assertSee('出勤時間もしくは退勤時間が不適切な値です');

        // ================================
        // ケース-2 出勤 09:00 / 退勤 18:00 / 休憩入 19:00 / 休憩戻 13:00
        // (休憩入が退勤後)
        // ================================
        $response = $this->post(
            route('admin.attendance.immediateUpdate', [
                'user' => 1,
                'date' => '2025-12-05',
            ]),
            [
                'clock_in'  => '09:00',
                'clock_out' => '18:00',
                'breaks' => [
                    [
                        'start' => '19:00',
                        'end'   => '13:00',
                    ],
                ],
            ]
        );
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/admin/attendance/1/2025-12-05');
        // 再表示された詳細画面にエラーメッセージが出る
        $errorPage = $this->get('/admin/attendance/1/2025-12-05');
        $errorPage->assertSee('休憩時間が不適切な値です');

        // ================================
        // ケース-3 出勤 09:00 / 退勤 18:00 / 休憩入 12:00 / 休憩戻 19:00
        // (休憩戻が退勤後)
        // ================================
        $response = $this->post(
            route('admin.attendance.immediateUpdate', [
                'user' => 1,
                'date' => '2025-12-05',
            ]),
            [
                'clock_in'  => '09:00',
                'clock_out' => '18:00',
                'breaks' => [
                    [
                        'start' => '12:00',
                        'end'   => '19:00',
                    ],
                ],
            ]
        );
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/admin/attendance/1/2025-12-05');
        // 再表示された詳細画面にエラーメッセージが出る
        $errorPage = $this->get('/admin/attendance/1/2025-12-05');
        $errorPage->assertSee('休憩時間もしくは退勤時間が不適切な値です');

        // ================================
        // ケース-4 出勤 09:00 / 退勤 18:00 / 休憩入 12:00 / 休憩戻 13:00 / 備考 空白
        // (備考が空白)
        // ================================
        $response = $this->post(
            route('admin.attendance.immediateUpdate', [
                'user' => 1,
                'date' => '2025-12-05',
            ]),
            [
                'clock_in'  => '09:00',
                'clock_out' => '18:00',
                'breaks' => [
                    [
                        'start' => '12:00',
                        'end'   => '13:00',
                    ],
                ],
                'reason' => '',   // ★ 備考を空白にする
            ]
        );
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/admin/attendance/1/2025-12-05');
        // 再表示された詳細画面にエラーメッセージが出る
        $errorPage = $this->get('/admin/attendance/1/2025-12-05');
        $errorPage->assertSee('備考を記入してください');

        // ログアウト（管理者）
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
