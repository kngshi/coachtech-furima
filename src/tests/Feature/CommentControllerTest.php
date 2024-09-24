<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('store.comment', $item->id), [
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect(route('create.comment', $item->id));
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);
    }

    public function test_user_cannot_create_comment_without_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('store.comment', $item->id), [
            'comment' => '',
        ]);

        $response->assertSessionHasErrors(['comment']);
    }

    public function test_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete(route('destroy.comment', ['item' => $item->id, 'comment' => $comment->id]));

        $response->assertRedirect(route('create.comment', $item->id));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_user_cannot_delete_others_comment()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $item = Item::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->delete(route('destroy.comment', ['item' => $item->id, 'comment' => $comment->id]));

        $response->assertRedirect(route('destroy.comment', $item->id));
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    public function test_admin_can_delete_any_comment()
    {
        $admin = User::factory()->create(['role' => 1]);
        $item = Item::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => User::factory()->create()->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($admin)->delete(route('destroy.comment', ['item' => $item->id, 'comment' => $comment->id]));

        $response->assertRedirect(route('create.comment', $item->id));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
