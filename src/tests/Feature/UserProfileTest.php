<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\ConditionMaster;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    // 必要な情報が取得できる
    public function test_user_profile_displays_required_information()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/mypage');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
    }

    // 変更項目が初期値として表示されている
    public function test_profile_edit_shows_current_values()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
            'email_verified_at' => now(),
        ]);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('テスト住所');
    }
}