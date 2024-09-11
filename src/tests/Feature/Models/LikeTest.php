<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Like;
use App\Models\User;
use App\Models\Item;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_like()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $like = Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals($user->id, $like->user_id);
        $this->assertEquals($item->id, $like->item_id);
    }

    public function test_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $like = Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertTrue($like->user->is($user));
    }

    public function test_belongs_to_an_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $like = Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertTrue($like->item->is($item));
    }
}
