<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Carbon\Carbon;

class T16_EmailAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_メール認証機能()
    {
        // メール送信をモック
        Notification::fake();

        // 会員登録
        $response = $this->post('/register', [
            'name' => '山田 太郎',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNull($user->email_verified_at);

        // 認証メールが送信されていること
        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );

        // メール認証導線画面が表示されること
        $verifyView = $this->actingAs($user)->get('/email/verify');
        $verifyView->assertStatus(200);
        $verifyView->assertSee('認証はこちらから');
        $verifyView->assertSee('http://localhost:8025/');

        // メール内の認証リンクを「踏んだ」ことを再現
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        $verifyResponse = $this->actingAs($user)->get($verificationUrl);

        // 認証完了後、勤怠登録画面へ遷移すること
        $verifyResponse->assertRedirectContains('/attendance');

        $this->assertNotNull(
            $user->fresh()->email_verified_at
        );

        $attendancePage = $this->actingAs($user)->get('/attendance');
        $attendancePage->assertStatus(200);
        $attendancePage->assertSee('出勤'); // 勤怠登録画面の文言
    }
}
