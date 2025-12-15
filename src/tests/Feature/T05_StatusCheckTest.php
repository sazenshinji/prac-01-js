<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T05_StatusCheckTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    private $email = '1234@abcd1';
    private $password = '12345678';

    public function test_ステータス確認機能_勤怠登録画面()
    {
        /**
         * 勤務外
         */
        // ログイン（セッションに login_role をセット）
        $response = $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ]);
        $response->assertRedirect('/attendance');
        // 勤怠登録画面
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ テータスが「勤務外」を確認
        $page->assertSee("勤務外");
        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        /**
         * 出勤中
         */
        // ログイン
        $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ])->assertRedirect('/attendance');

        // 画面表示を取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ ステータス出勤中か確認
        $page->assertSee("出勤中");
        // 休憩入ボタン押下
        $this->post('/attendance/break-in')->assertRedirect('/attendance');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        /**
         * 休憩中
         */
        // ログイン
        $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ])->assertRedirect('/attendance');

        // 画面表示
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ ステータスが休憩中を確認
        $page->assertSee("休憩中");
        // 休憩戻 → 退勤
        $this->post('/attendance/break-out')->assertRedirect('/attendance');
        $this->post('/attendance/clock-out')->assertRedirect('/attendance');
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();

        /**
         * 退勤済
         */
        // ログイン
        $this->withSession(['login_role' => 'user'])
            ->post('/login', [
                'email' => $this->email,
                'password' => $this->password,
            ])->assertRedirect('/attendance');

        // 表示画面
        $page = $this->get('/attendance');
        $page->assertStatus(200);
        // ★ ステータスが退勤済を確認
        $page->assertSee("退勤済");
        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }
}
