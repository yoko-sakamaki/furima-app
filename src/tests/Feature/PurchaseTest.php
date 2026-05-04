<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use App\Models\ConditionMaster;
use Tests\TestCase;

class PurchaseTest extends TestCase
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

    // 購入するボタンを押すと購入が完了する
    public function test_user_can_purchase_item()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($seller->id);

        Address::create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
        ]);

        $response = $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 'convenience',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);
    }

    // 購入した商品はSoldと表示される
    public function test_purchased_item_shows_sold_label()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($seller->id);

        Address::create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
        ]);

        $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 'convenience',
        ]);

        $response = $this->get('/');
        $response->assertSee('Sold');
    }

    // 購入した商品がマイページに表示される
    public function test_purchased_item_appears_in_mypage()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($seller->id);

        Address::create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
        ]);

        $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 'convenience',
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');
        $response->assertSee('テスト商品');
    }

    // 支払い方法選択が小計画面に反映される
    public function test_payment_method_is_reflected()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($seller->id);

        $response = $this->actingAs($buyer)->get('/purchase/' . $item->id);
        $response->assertSee('コンビニ払い');
        $response->assertSee('カード払い');
    }

    // 住所変更が購入画面に反映される
    public function test_address_change_is_reflected_in_purchase()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($seller->id);

        $this->actingAs($buyer)->post('/purchase/address/' . $item->id, [
            'postal_code' => '123-4567',
            'address' => '大阪市テスト区',
            'building' => 'テストビル',
        ]);

        $response = $this->actingAs($buyer)->get('/purchase/' . $item->id);
        $response->assertSee('123-4567');
        $response->assertSee('大阪市テスト区');
    }

    // 購入した商品に住所が紐づいている
    public function test_purchased_item_has_address()
    {
        $seller = User::create([
            'name' => '出品者',
            'email' => 'seller@example.com',
            'password' => Hash::make('password123'),
        ]);

        $buyer = User::create([
            'name' => '購入者',
            'email' => 'buyer@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($seller->id);

        $address = Address::create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => 'テスト住所',
        ]);

        $this->actingAs($buyer)->post('/purchase/' . $item->id, [
            'payment_method' => 'convenience',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'address_id' => $address->id,
        ]);
    }
}