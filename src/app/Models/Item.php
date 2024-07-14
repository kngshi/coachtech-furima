<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'img_url',
        'user_id',
        'category_item_id',
        'condition_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_items');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    // いいねしたユーザー
    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    // コメントしたユーザー
    public function commentedByUsers()
    {
        return $this->belongsToMany(User::class, 'comments')->withPivot('comment');
    }

    // 購入したユーザー
    public function purchasedByUsers()
    {
        return $this->belongsToMany(User::class, 'sold_items');
    }
}
