<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T03_LoginAdminTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    public function test_ログイン認証機能（管理者）_バリデーション_email_required()
    {
        // 管理者ログイン画面では session に login_role=admin がセットされるが
        session(['login_role' => 'admin']);
        // email 未入力
        $formData = [
            // 'email' => '1234@abcd5',
            'password' => '12345678',
        ];
        // POST /login を実行
        $response = $this->post('/login', $formData);
        // バリデーションエラー（email）が存在すること
        $response->assertSessionHasErrors(['email']);
        // エラーメッセージを取得
        $errors = session('errors')->getMessages();
        // ★ メッセージ内容チェック
        $this->assertEquals('メールアドレスを入力してください', $errors['email'][0]);
    }

    public function test_ログイン認証機能（管理者）_バリデーション_password_required()
    {
        // 管理者ログイン画面では session に login_role=admin がセットされるが
        session(['login_role' => 'admin']);
        // password 未入力
        $formData = [
            'email' => '1234@abcd5',
            // 'password' => '12345678',
        ];
        // POST /login を実行
        $response = $this->post('/login', $formData);
        // エラー確認
        $response->assertSessionHasErrors(['password']);
        // エラーメッセージを取得
        $errors = session('errors')->getMessages();
        // ★ メッセージ内容チェック
        $this->assertEquals('パスワードを入力してください', $errors['password'][0]);
    }

    public function test_ログイン認証機能（管理者）_バリデーション_wronginformation_email()
    {
        // 管理者ログイン画面では session に login_role=admin がセットされるが
        session(['login_role' => 'admin']);
        // 存在しない email を送信
        $formData = [
            'email' => '1234@abcd1', // 一般ユーザーの email → 管理者画面では不正扱い
            'password' => '12345678',
        ];
        // POST /login を実行
        $response = $this->post('/login', $formData);
        // エラー確認
        $response->assertSessionHasErrors(['email']);
        // エラーメッセージを取得
        $errors = session('errors')->getMessages();
        // ★ 管理者の認証情報として不正
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }

    public function test_ログイン認証機能（管理者）_バリデーション_wronginformation_password()
    {
        // 管理者ログイン画面では session に login_role=admin がセットされるが
        session(['login_role' => 'admin']);
        // 間違い password
        $formData = [
            'email' => '1234@abcd5',  // Seeder の管理者
            'password' => '12345679', // 誤り
        ];
        // POST /login を実行
        $response = $this->post('/login', $formData);
        // エラー確認
        $response->assertSessionHasErrors(['email']);
        // エラーメッセージを取得
        $errors = session('errors')->getMessages();
        // ★ パスワード不正
        $this->assertEquals('ログイン情報が登録されていません', $errors['email'][0]);
    }

    public function test_ログイン認証機能（管理者）_正常動作_LoginLogout()
    {
        // 管理者ログイン画面では session に login_role=admin がセットされるが
        session(['login_role' => 'admin']);
        // 正しい Emaile、password
        $email = '1234@abcd5';   // Seeder 管理者 email
        $password = '12345678';
        // ログイン実行
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);
        // ★ 正しく管理者画面に遷移すること
        $response->assertRedirect('/admin/attendance/list');
        // ★ 認証済みであることを確認
        $this->assertAuthenticated();
        // ログアウト
        $logout = $this->post('/logout');
        // ★ ログアウト後 login 画面へ戻る
        $logout->assertRedirect('/admin/login');
        // ★ ログアウト状態であること
        $this->assertGuest();
    }
}
