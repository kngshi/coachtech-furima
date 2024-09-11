<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Profile;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'img_url' => $this->faker->imageUrl(),
            'postcode' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->optional()->word(),
        ];
    }
}
