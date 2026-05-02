<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\ConditionMaster;
use Tests\TestCase;

class CommentTest extends TestCase
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

    // ログイン済みユーザーはコメントを送信できる
    public function test_authenticated_user_can_post_comment()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($user->id);

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'body' => 'テストコメント',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'body' => 'テストコメント',
        ]);
    }

    // ログイン前のユーザーはコメントを送信できない
    public function test_guest_cannot_post_comment()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($user->id);

        $response = $this->post('/comment/' . $item->id, [
            'body' => 'テストコメント',
        ]);

        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments', [
            'body' => 'テストコメント',
        ]);
    }

    // コメントが入力されていない場合バリデーションメッセージが表示される
    public function test_comment_body_is_required()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($user->id);

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'body' => '',
        ]);

        $response->assertSessionHasErrors(['body' => 'コメントを入力してください']);
    }

    // コメントが255文字以上の場合バリデーションメッセージが表示される
    public function test_comment_body_max_255_characters()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($user->id);

        $response = $this->actingAs($user)->post('/comment/' . $item->id, [
            'body' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors(['body' => 'コメントは255文字以内で入力してください']);
    }
}