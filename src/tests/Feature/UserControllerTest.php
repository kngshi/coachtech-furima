<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\SoldItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testGetUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $items = Item::factory()->count(3)->create(['user_id' => $user->id]);

        $soldItems = SoldItem::factory()->count(2)->create(['user_id' => $user->id]);

        $response = $this->get('/mypage');

        $response->assertStatus(200);

        $response->assertViewHas('profile', $profile);
        $response->assertViewHas('items', function($viewItems) use ($items) {
            return $viewItems->pluck('id')->toArray() === $items->pluck('id')->toArray();
        });
        $response->assertViewHas('soldItems', function($viewSoldItems) use ($soldItems) {
            return $viewSoldItems->pluck('id')->toArray() === $soldItems->pluck('id')->toArray();
        });
    }
}