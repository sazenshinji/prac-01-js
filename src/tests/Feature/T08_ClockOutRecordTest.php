<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T08_ClockOutRecordTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    private $email = '1234@abcd1';
    private $password = '12345678';

    public function test_退勤機能_退勤ボタン_勤怠登録画面()
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

        // 退勤ボタンが表示されていることを確認
        $page->assertSee('退勤');

        // 退勤ボタン押下
        $this->post('/attendance/clock-out')->assertRedirect('/attendance');

        // 勤怠登録画面を再取得
        $page = $this->get('/attendance');
        $page->assertStatus(200);

        // ステータスが「退勤済」になっていることを確認
        $page->assertSee('退勤済');

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }
}
