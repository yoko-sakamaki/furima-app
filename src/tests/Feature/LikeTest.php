<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\ConditionMaster;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    private function createItem($userId)
    {
        $condition = ConditionMaster::create(['name' => '良好']);
        return Item::create([
            'user_id' => $userId,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'description' => 'テスト説明',
            'price' => 1000,
            'image' => 'test.jpg',
            'is_sold' => false,
        ]);
    }

    // いいねすると登録されいいね数が増加する
    public function test_user_can_like_item()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $other = User::create([
            'name' => '他のユーザー',
            'email' => 'other@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($other->id);

        $this->actingAs($user)->post('/like/' . $item->id);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    // いいね済みはアイコンの色が変化する
    public function test_liked_item_shows_active_icon()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $other = User::create([
            'name' => '他のユーザー',
            'email' => 'other@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($other->id);
        Like::create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/item/' . $item->id);
        $response->assertSee('icon-heart-pink.svg');
    }

    // いいねを再度押すと解除される
    public function test_user_can_unlike_item()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $other = User::create([
            'name' => '他のユーザー',
            'email' => 'other@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($other->id);
        Like::create(['user_id' => $user->id, 'item_id' => $item->id]);

        $this->actingAs($user)->post('/like/' . $item->id);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}