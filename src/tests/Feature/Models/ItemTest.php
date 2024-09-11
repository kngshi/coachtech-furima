<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;

class ItemTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_an_item()
    {
        $item = Item::factory()->create();

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'name' => $item->name,
        ]);
    }

    public function test_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($item->user->is($user));
    }

    public function test_belongs_to_many_categories()
    {
        $item = Item::factory()->create();
        $categories = Category::factory()->count(2)->create();

        $item->categories()->attach($categories);

        $this->assertEquals(2, $item->categories()->count());
        $this->assertTrue($item->categories->contains($categories[0]));
        $this->assertTrue($item->categories->contains($categories[1]));
    }

    public function test_belongs_to_a_condition()
    {
        $condition = Condition::factory()->create();
        $item = Item::factory()->create(['condition_id' => $condition->id]);

        $this->assertTrue($item->condition->is($condition));
    }

    public function test_has_many_likes()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        $item->likes()->create(['user_id' => $user->id]);

        $this->assertEquals(1, $item->likes()->count());
    }

    public function test_has_many_comments()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        $item->comments()->create(['user_id' => $user->id, 'comment' => 'Nice item!']);

        $this->assertEquals(1, $item->comments()->count());
    }

    public function test_has_many_liked_by_users()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        $item->likedByUsers()->attach($user);

        $this->assertEquals(1, $item->likedByUsers()->count());
    }

    public function test_has_many_commented_by_users()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        $item->commentedByUsers()->attach($user, ['comment' => 'Nice item!']);

        $this->assertEquals(1, $item->commentedByUsers()->count());
    }

    public function test_has_many_purchased_by_users()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        $item->purchasedByUsers()->attach($user);

        $this->assertEquals(1, $item->purchasedByUsers()->count());
    }
}
