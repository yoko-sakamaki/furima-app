<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'condition_id',
        'name',
        'brand',
        'description',
        'price',
        'image',
        'is_sold',
    ];

    // 出品者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 商品状態
    public function condition()
    {
        return $this->belongsTo(ConditionMaster::class, 'condition_id');
    }

    // カテゴリ（多対多）
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'item_categories');
    }

    // いいね
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 購入情報
    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}