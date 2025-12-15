<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T11_DetailCorrectionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    // 渋野 日向子
    private $email = '1234@abcd4';
    private $password = '12345678';

    public function test_勤怠詳細情報修正機能（一般ユーザー）_バリデーション_勤怠詳細画面()
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

        // ================================
        // ケース-1 出勤 19:00 / 退勤 18:00
        // (出勤、退勤が逆転)
        // ================================
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-01',
            'clock_in'  => '19:00',
            'clock_out' => '18:00',
            'reason'    => 'テスト修正',
        ]);
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/attendance/detail/2025-12-01');
        // バリデーションエラーメッセージ確認
        $response = $this->get('/attendance/detail/2025-12-01');
        $response->assertSee('出勤時間もしくは退勤時間が不適切な値です');

        // ================================
        // ケース-2 出勤 09:00 / 退勤 08:00
        // (出勤、退勤が逆転)
        // ================================
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-01',
            'clock_in'  => '09:00',
            'clock_out' => '08:00',
            'reason'    => 'テスト修正',
        ]);
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/attendance/detail/2025-12-01');
        // バリデーションエラーメッセージ確認
        $response = $this->get('/attendance/detail/2025-12-01');
        $response->assertSee('出勤時間もしくは退勤時間が不適切な値です');

        // ================================
        // ケース-3 出勤 09:00 / 退勤 18:00 / 休憩入 19:00 / 休憩戻 13:00
        // (休憩入が退勤後)
        // ================================
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-01',
            'clock_in'  => '09:00',
            'clock_out' => '18:00',
            'breaks' => [
                [
                    'start' => '19:00',
                    'end'   => '13:00',
                ],
            ],
            'reason'    => 'テスト修正',
        ]);
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/attendance/detail/2025-12-01');
        // バリデーションエラーメッセージ確認
        $response = $this->get('/attendance/detail/2025-12-01');
        $response->assertSee('休憩時間が不適切な値です');

        // ================================
        // ケース-4 出勤 09:00 / 退勤 18:00 / 休憩入 12:00 / 休憩戻 19:00
        // (休憩戻が退勤後)
        // ================================
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-01',
            'clock_in'  => '09:00',
            'clock_out' => '18:00',
            'breaks' => [
                [
                    'start' => '12:00',
                    'end'   => '19:00',
                ],
            ],
            'reason'    => 'テスト修正',
        ]);
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/attendance/detail/2025-12-01');
        // バリデーションエラーメッセージ確認
        $response = $this->get('/attendance/detail/2025-12-01');
        $response->assertSee('休憩時間もしくは退勤時間が不適切な値です');

        // ================================
        // ケース-5 出勤 09:00 / 退勤 18:00 / 休憩入 12:00 / 休憩戻 13:00 / 備考 空白
        // (備考が空白)
        // ================================
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-01',
            'clock_in'  => '09:00',
            'clock_out' => '18:00',
            'breaks' => [
                [
                    'start' => '12:00',
                    'end'   => '13:00',
                ],
            ],
            'reason'    => '',
        ]);
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/attendance/detail/2025-12-01');
        // バリデーションエラーメッセージ確認
        $response = $this->get('/attendance/detail/2025-12-01');
        $response->assertSee('備考を記入してください');

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }

    public function test_勤怠詳細情報修正機能（一般ユーザー）_勤怠修正処理_勤怠詳細画面()
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

        // 勤怠情報変更 出勤 09:00 / 退勤 18:00 / 休憩入 12:10 / 休憩戻 13:10 / 備考 テスト修正
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-01',
            'clock_in'  => '09:11',
            'clock_out' => '18:12',
            'breaks' => [
                [
                    'start' => '12:13',
                    'end'   => '13:14',
                ],
            ],
            'reason'    => 'テスト',
        ]);
        // 詳細画面にリダイレクトされる
        $response->assertRedirect('/attendance/detail/2025-12-01');

        // ログアウトする。
        // 管理者でログイン(login_role=管理者) 
        // URL=http://localhost/admin/login
        // (長嶋 茂雄  email = '1234@abcd5',password = '12345678')

        //勤怠一覧画面(管理者)が開くことを確認する。
        //[http://localhost/admin/attendance/list]

        //ヘッダー部の[申請一覧]ボタンを押す

        //申請一覧画面(管理者)が開くことを確認する。
        //[http://localhost/stamp_correction_request/list]

        //その画面の「承認待ち」タブに、
        // 「状態：承認待ち」「名前：渋野 日向子」「対象日：2025/12/01」
        // 「申請理由：テスト」「申請日：2025/12/12」が表示されていることを確認する。

        //その行の[詳細]ボタンを押す

        //修正申請承認画面(管理者)が表示されることを確認する。
        //[http://localhost/stamp_correction_request/approve/8]

        //その画面の表示を確認する。
        //「名前：渋野 日向子」「日付：2025年12月1日」「出勤・退勤：09:11 ～ 18:12」
        // 「休憩：12:13 ～ 13:14」「備考：テスト」






        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }


    }
}
