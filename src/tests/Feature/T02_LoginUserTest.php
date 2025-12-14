<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T02_LoginUserTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_ログイン認証機能（一般ユーザー）_バリデーション_email_required()
    {
        //フォームデータ
        $formData = [
            // 'email' => '1234@abcd',
            'password' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'email',
            // 'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }
    public function test_ログイン認証機能（一般ユーザー）_バリデーション_password_required()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd',
            // 'password' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'email',
            'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }
    public function test_ログイン認証機能（一般ユーザー）_バリデーション_wronginformation_email()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd5',             //間違ったemailアドレス
            'password' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'email',
            // 'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }
    public function test_ログイン認証機能（一般ユーザー）_バリデーション_wronginformation_password()
    {
        //フォームデータ
        $formData = [
            'email' => '1234@abcd1',
            'password' => '12345679',       //間違ったPassword
        ];
        // POSTリクエスト
        $response = $this->post('/login', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'email',
            // 'password',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // エラーメッセージを確認
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }
    public function test_ログイン認証機能（一般ユーザー）_正常動作_LoginLogout()
    {
        // ★ Fortify の login_role（一般ユーザー想定）をセット
        session(['login_role' => 'user']);

        // ★ Seeder で作成されている一般ユーザー
        $email = '1234@abcd1';
        $password = '12345678';

        // ★ ログイン実行
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);

        // ★ 正しい画面へリダイレクトされるか確認
        $response->assertRedirect('/attendance');

        // ★ 認証済みであること（ログイン状態）
        $this->assertAuthenticated();

        // ★ ログアウト実行（POST /logout）
        $logout = $this->post('/logout');

        // ★ ログアウト後は login 画面へ
        $logout->assertRedirect('/login');

        // ★ 認証状態が解除されていること
        $this->assertGuest();
    }
}
