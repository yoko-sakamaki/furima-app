<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;
use Tests\TestCase;

class MailVerificationTest extends TestCase
{
    use RefreshDatabase;

    // 会員登録後、認証メールが送信される
    public function test_verification_email_is_sent_after_registration()
    {
        Notification::fake();

        $response = $this->post('/register', [
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    // メール認証誘導画面が表示される
    public function test_verify_email_screen_is_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->actingAs($user)->get('/email/verify');
        $response->assertStatus(200);
    }

    // メール認証を完了するとプロフィール設定画面に遷移する
    public function test_email_verification_redirects_to_profile()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);
        $response->assertRedirect('/mypage/profile?verified=1');
    }
}