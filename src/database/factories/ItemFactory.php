<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;

class ItemFactory extends Factory
{
    protected $model = Item::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(1000, 10000),
            'brand' => $this->faker->word,
            'description' => $this->faker->text,
            'img_url' => $this->faker->imageUrl,
            'user_id' => \App\Models\User::factory(),
            'condition_id' => \App\Models\Condition::factory(),
        ];
    }
}
