<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\ConditionMaster;
use Tests\TestCase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_exhibit_item()
    {
        Storage::fake('public');

        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        $condition = ConditionMaster::create(['name' => '良好']);
        $category = Category::create(['name' => 'テストカテゴリ']);

        $response = $this->actingAs($user)->post('/sell', [
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'condition_id' => $condition->id,
            'categories' => [$category->id],
            'image' => UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg'),
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
        ]);
    }
}