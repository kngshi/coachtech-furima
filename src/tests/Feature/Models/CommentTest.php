<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'This is a test comment',
        ]);

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertEquals($user->id, $comment->user->id);
    }

    public function test_comment_belongs_to_an_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'This is a test comment',
        ]);

        $this->assertInstanceOf(Item::class, $comment->item);
        $this->assertEquals($item->id, $comment->item->id);
    }
}