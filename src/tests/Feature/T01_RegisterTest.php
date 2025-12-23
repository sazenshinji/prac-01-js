<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T01_RegisterTest extends TestCase
{

    use RefreshDatabase;
    protected $seed = true;

    public function test_認証機能（一般ユーザー）_バリデーション_name_required()
    {
        //フォームデータ
        $formData = [
            // 'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            'name',
            // 'email',
            // 'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // ★ エラーメッセージを確認
        $this->assertEquals('お名前を入力してください', $errors['name'][0]);
    }

    public function test_認証機能（一般ユーザー）_バリデーション_email_required()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            // 'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            'email',
            // 'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // ★ エラーメッセージを確認
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }

    public function test_認証機能（一般ユーザー）_バリデーション_password_min()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '1234567',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            // 'email',
            'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // ★ エラーメッセージを確認
        $this->assertEquals('パスワードは8文字以上で入力してください', $errors['password'][0]);
    }

    public function test_認証機能（一般ユーザー）_バリデーション_password_confirmed()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345679',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            // 'email',
            'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // ★ エラーメッセージを確認
        $this->assertEquals('パスワードと一致しません', $errors['password'][0]);
    }

    public function test_認証機能（一般ユーザー）_バリデーション_password_required()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            // 'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);
        // バリデーションエラー発生を確認
        $response->assertSessionHasErrors([
            // 'name',
            // 'email',
            'password',
            // 'password_confirmatio',
        ]);
        // セッションのエラー取得
        $errors = session('errors')->getMessages();
        // ★ エラーメッセージを確認
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }

    public function test_認証機能（一般ユーザー）_登録確認()
    {
        //フォームデータ
        $formData = [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ];
        // POSTリクエスト
        $response = $this->post('/register', $formData);

        // 登録後にリダイレクトが発生することを確認（任意）
        $response->assertStatus(302);

        // ★ usersテーブルに登録されたことを確認
        $this->assertDatabaseHas('users', [
            'name' => '山田 太郎',
            'email' => '1234@abcd',
            // password はハッシュ化されるのでチェック不要（または cannot check）
            'role' => 0,
        ]);
    }
}
