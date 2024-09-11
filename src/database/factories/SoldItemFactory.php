<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\SoldItem;
use App\Models\User;

class SoldItemFactory extends Factory
{
    protected $model = SoldItem::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'payment_method_id' => PaymentMethod::factory(),
        ];
    }
}