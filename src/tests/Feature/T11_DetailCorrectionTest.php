<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Correction;

class T11_DetailCorrectionTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    // 渋野 日向子
    private $email = '1234@abcd4';
    private $password = '12345678';

    // 案件シート テストケース一覧【41～44行目】
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


    // 案件シート テストケース一覧【45行目】
    public function test_勤怠詳細情報修正機能（一般ユーザー）_申請確認_管理者()
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

        // 勤怠情報変更 出勤 09:11 / 退勤 18:12 / 休憩入 12:13 / 休憩戻 13:14 / 備考 テスト
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

        // 一般ユーザー ログアウト
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();

        // 管理者ログイン
        $this->withSession(['login_role' => 'admin'])
            ->post('/login', [
                'email' => '1234@abcd5',
                'password' => '12345678',
            ])
            ->assertRedirect('/admin/attendance/list');

        // 申請一覧（承認待ち）
        $this->get('/stamp_correction_request/list?tab=pending')
            ->assertStatus(200)
            ->assertSee('渋野 日向子')
            ->assertSee('2025/12/01')
            ->assertSee('テスト');


        // 正しい申請ID取得（attendance 経由）
        $user = User::where('email', $this->email)->first();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('work_date', '2025-12-01')
            ->first();

        $correctionId = Correction::where('attendance_id', $attendance->id)
            ->whereNull('approved_at')   // ← 未承認だけ
            ->latest()
            ->first()
            ->id;

        // 申請詳細画面
        $detail = $this->get(route('request.detail', ['id' => $correctionId]));
        $detail->assertStatus(200);
        $detail->assertSee('申請詳細');
        $detail->assertSee('渋野 日向子');
        $detail->assertSee('2025年');
        $detail->assertSee('12月');
        $detail->assertSee('1日');
        $detail->assertSee('09:11');
        $detail->assertSee('18:12');
        $detail->assertSee('12:13');
        $detail->assertSee('13:14');
        $detail->assertSee('テスト');

        // ログアウト（管理者）
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();

        // テスト時刻固定を解除
        Carbon::setTestNow();
    }

    // 案件シート テストケース一覧【46行目】
    public function test_勤怠詳細情報修正機能（一般ユーザー）_申請確認_ユーザー()
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

        // 勤怠情報変更
        //日付 2025-12-01 / 出勤 09:11 / 退勤 18:12 / 休憩入 12:13 / 休憩戻 13:14 / 備考 テスト1
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
            'reason'    => 'テスト1',
        ]);
        // 勤怠情報変更
        // 日付 2025-12-02 / 出勤 09:21 / 退勤 18:22 / 休憩入 12:23 / 休憩戻 13:24 / 備考 テスト2
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-02',
            'clock_in'  => '09:21',
            'clock_out' => '18:22',
            'breaks' => [
                [
                    'start' => '12:23',
                    'end'   => '13:24',
                ],
            ],
            'reason'    => 'テスト2',
        ]);

        // ユーザー自身の申請一覧を確認
        // ヘッダーの[申請]ボタン押下と同義
        $response = $this->get('/stamp_correction_request/list');
        // 申請一覧画面が表示されること
        $response->assertStatus(200);
        $response->assertSee('申請一覧');
        // 承認待ち」タブが表示されていること
        $response->assertSee('承認待ち');
        // ================================
        // 申請1（2025-12-01）
        // ================================
        $response->assertSee('承認待ち');              // 状態
        $response->assertSee('渋野 日向子');          // 名前
        $response->assertSee('2025/12/01');            // 対象日時
        $response->assertSee('テスト1');               // 申請理由
        $response->assertSee('2025/12/12');            // 申請日
        // ================================
        // 申請2（2025-12-02）
        // ================================
        $response->assertSee('2025/12/02');            // 対象日時
        $response->assertSee('テスト2');               // 申請理由

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }


    // 案件シート テストケース一覧【47行目】
    public function test_勤怠詳細情報修正機能（一般ユーザー）_承認確認_管理者()
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

        // 勤怠情報変更 出勤 09:11 / 退勤 18:12 / 休憩入 12:13 / 休憩戻 13:14 / 備考 テスト
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
            'reason'    => 'テスト1',
        ]);
        // 勤怠情報変更
        // 日付 2025-12-02 / 出勤 09:21 / 退勤 18:22 / 休憩入 12:23 / 休憩戻 13:24 / 備考 テスト2
        $response = $this->post(route('attendance.detail.update'), [
            'date'      => '2025-12-02',
            'clock_in'  => '09:21',
            'clock_out' => '18:22',
            'breaks' => [
                [
                    'start' => '12:23',
                    'end'   => '13:24',
                ],
            ],
            'reason'    => 'テスト2',
        ]);

        // 一般ユーザー ログアウト
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
        // 管理者ログイン
        $this->withSession(['login_role' => 'admin'])
            ->post('/login', [
                'email' => '1234@abcd5',
                'password' => '12345678',
            ])
            ->assertRedirect('/admin/attendance/list');

        // 管理者ヘッダーの[申請一覧]ボタン押下
        $response = $this->get('/stamp_correction_request/list');
        // 申請一覧画面が表示され、承認待ちタブであること
        $response->assertStatus(200);
        $response->assertSee('申請一覧');
        $response->assertSee('承認待ち');
        // 承認待ち申請 2件が表示されていること
        // 2025/12/01
        $response->assertSee('承認待ち');
        $response->assertSee('渋野 日向子');
        $response->assertSee('2025/12/01');
        // 2025/12/02
        $response->assertSee('2025/12/02');
        // 対象日 2025/12/01 の申請IDを取得
        $user = User::where('email', $this->email)->first();
        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('work_date', '2025-12-01')
            ->first();
        $correction = Correction::where('attendance_id', $attendance->id)
            ->whereNull('approved_at')   // 未承認のみ
            ->latest()
            ->first();
        $this->assertNotNull($correction);

        // [詳細]ボタン押下（＝申請詳細画面）
        $detail = $this->get(route('request.detail', ['id' => $correction->id]));
        $detail->assertStatus(200);
        $detail->assertSee('申請詳細');
        // 申請詳細画面の表示確認
        $detail->assertSee('渋野 日向子');
        $detail->assertSee('2025年');
        $detail->assertSee('12月');
        $detail->assertSee('1日');

        // ボタン押下
        $approve = $this->post(
            route('admin.request.approve', ['id' => $correction->id])
        );
        // 承認後は詳細画面へ戻る（設計に応じて）
        $approve->assertRedirect();
        // ボタンが「承認済み」に変わったことを確認
        $detailAfter = $this->get(route('request.detail', ['id' => $correction->id]));
        $detailAfter->assertStatus(200);
        $detailAfter->assertSee('承認済み');
        // 再度 [申請一覧] へ戻る
        $listAfter = $this->get('/stamp_correction_request/list');
        $listAfter->assertStatus(200);

        // 対象日 2025/12/02 の申請を承認
        // 対象日 2025/12/02 の申請ID取得
        $attendance02 = Attendance::where('user_id', $user->id)
            ->whereDate('work_date', '2025-12-02')
            ->first();

        $correction02 = Correction::where('attendance_id', $attendance02->id)
            ->whereNull('approved_at')
            ->latest()
            ->first();

        $this->assertNotNull($correction02);
        // [詳細]ボタン押下（2025/12/02）
        $detail02 = $this->get(route('request.detail', ['id' => $correction02->id]));
        $detail02->assertStatus(200);
        $detail02->assertSee('申請詳細');
        // 表示内容確認
        $detail02->assertSee('渋野 日向子');
        $detail02->assertSee('2025年');
        $detail02->assertSee('12月');
        $detail02->assertSee('2日');
        // [承認]ボタン押下
        $approve02 = $this->post(
            route('admin.request.approve', ['id' => $correction02->id])
        );
        $approve02->assertRedirect();
        // 承認済み表示確認
        $detailAfter02 = $this->get(route('request.detail', ['id' => $correction02->id]));
        $detailAfter02->assertStatus(200);
        $detailAfter02->assertSee('承認済み');
        // 承認済みタブ確認
        // 申請一覧へ戻る
        $approvedList = $this->get('/stamp_correction_request/list?tab=approved');
        $approvedList->assertStatus(200);
        $approvedList->assertSee('承認済み');
        // 承認済み 2件表示確認
        // 2025/12/01
        $approvedList->assertSee('承認済み');
        $approvedList->assertSee('渋野 日向子');
        $approvedList->assertSee('2025/12/01');
        $approvedList->assertSee('テスト1');
        $approvedList->assertSee('2025/12/12');
        // 2025/12/02
        $approvedList->assertSee('2025/12/02');
        $approvedList->assertSee('テスト2');

        // 管理者ログアウト
        $this->post('/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }

    // 案件シート テストケース一覧【48行目】
    public function test_勤怠詳細情報修正機能（一般ユーザー）_申請詳細確認_ユーザー()
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

        // 勤怠情報変更
        //日付 2025-12-01 / 出勤 09:11 / 退勤 18:12 / 休憩入 12:13 / 休憩戻 13:14 / 備考 テスト1
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
            'reason'    => 'テスト1',
        ]);

        // ユーザー自身の申請一覧を確認
        // ヘッダーの[申請]ボタン押下と同義
        $response = $this->get('/stamp_correction_request/list');
        // 申請一覧画面が表示されること
        $response->assertStatus(200);
        $response->assertSee('申請一覧');
        // 承認待ち」タブが表示されていること
        $response->assertSee('承認待ち');
        // 申請（2025-12-01）一覧の確認
        $response->assertSee('承認待ち');              // 状態
        $response->assertSee('渋野 日向子');          // 名前
        $response->assertSee('2025/12/01');            // 対象日時
        $response->assertSee('テスト1');               // 申請理由
        $response->assertSee('2025/12/12');            // 申請日

        // 申請詳細画面（ユーザー）確認
        // 対象日 2025-12-01 の申請IDを取得
        $user = User::where('email', $this->email)->first();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('work_date', '2025-12-01')
            ->first();

        $correction = Correction::where('attendance_id', $attendance->id)
            ->whereNull('approved_at')   // ← ★ 承認待ちタブと同じ条件
            ->latest()
            ->first();

        $this->assertNotNull($correction);

        // [詳細]ボタン押下（＝申請詳細画面へ）
        $detail = $this->get(route('request.detail', ['id' => $correction->id]));
        $detail->assertStatus(200);

        // 修正申請承認画面が表示されること
        $detail->assertSee('申請詳細');
        // 表示内容確認
        $detail->assertSee('渋野 日向子');   // 名前
        $detail->assertSee('2025年');         // 年
        $detail->assertSee('12月');           // 月
        $detail->assertSee('1日');            // 日
        // 出勤・退勤
        $detail->assertSee('09:11');
        $detail->assertSee('18:12');
        // 休憩
        $detail->assertSee('12:13');
        $detail->assertSee('13:14');
        // 備考
        $detail->assertSee('テスト1');

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
        // テスト時刻固定を解除
        Carbon::setTestNow();
    }
}
