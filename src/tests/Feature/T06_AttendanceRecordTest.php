<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class T06_AttendanceRecordTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    private $email = '1234@abcd1';
    private $password = '12345678';

    public function test_出勤機能_勤怠登録_勤怠一覧画面()
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

        // ステータスが「勤務外」を確認
        $page->assertSee("勤務外");

        // 「出勤」ボタンが表示されていることを確認
        $page->assertSee('出勤');

        // 出勤ボタン押下
        $this->post('/attendance/clock-in')->assertRedirect('/attendance');

        // 画面を再取得する
        $page = $this->get('/attendance');
        
        // ステータス「出勤中」か確認
        $page->assertSee("出勤中");

        // 退勤ボタン押下
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

        // 退勤済を確認
        $page->assertSee("退勤済");

        // 勤怠ボタンが表示されていないことを確認
        $page->assertDontSee('>出勤<', false);
        $page->assertDontSee('>退勤<', false);
        $page->assertDontSee('>休憩入<', false);
        $page->assertDontSee('>休憩戻<', false);

        // ログアウト
        $logout = $this->post('/logout');
        $logout->assertRedirect('/login');
        $this->assertGuest();
    }
}
