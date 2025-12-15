<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class T10_DetailDisplayTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    // 渋野 日向子
    private $email = '1234@abcd4';
    private $password = '12345678';

    public function test_勤怠詳細情報取得機能（一般ユーザー）_表示情報確認_勤怠詳細画面()
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
        
        // ★表示内容確認
        $detail->assertSee('渋野 日向子');

        $detail->assertSee('2025年');
        $detail->assertSee('12月');
        $detail->assertSee('1日');

        $detail->assertSee('09:01');
        $detail->assertSee('18:06');

        $detail->assertSee('12:00');
        $detail->assertSee('13:01');

        // ログアウト
        $this->post('/logout')->assertRedirect('/login');
        $this->assertGuest();
        // 時刻固定解除
        Carbon::setTestNow();

    }
}
