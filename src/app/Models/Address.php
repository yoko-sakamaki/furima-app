<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'postal_code',
        'address',
        'building',
    ];

    // 住所のユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // この住所の購入履歴
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}