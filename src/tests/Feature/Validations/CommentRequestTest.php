<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;

class CommentRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_requires_a_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Auth::login($user);

        $response = $this->post('/item/' . $item->id . '/comment', []);

        $response->assertStatus(302)
                 ->assertSessionHasErrors('comment');
    }

    public function test_requires_comment_to_be_string()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Auth::login($user);

        $response = $this->post('/item/' . $item->id . '/comment', ['comment' => 12345]);

        $response->assertStatus(302)
                 ->assertSessionHasErrors('comment');
    }

    public function test_requires_comment_to_be_max_100_characters()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Auth::login($user);

        $response = $this->post('/item/' . $item->id . '/comment', ['comment' => str_repeat('a', 101)]);

        $response->assertStatus(302)
                 ->assertSessionHasErrors('comment');
    }

    public function test_allows_valid_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Auth::login($user);

        $response = $this->post('/item/' . $item->id . '/comment', ['comment' => 'This is a valid comment.']);

        $response->assertStatus(302)
                 ->assertSessionHas('create', 'コメントが追加されました。');
    }
}
