<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;


class AdminControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('admin1234'),
            'role' => 1,
        ]);

        $this->adminUser->profile()->create([
            'postcode' => '1234567', // 郵便番号
            'address' => 'Sample Address', // 住所
            'building' => 'Sample Building', // 建物名（任意）
        ]);

        $this->actingAs($this->adminUser);
    }

    public function test_admin_page_is_accessible()
    {
        $response = $this->get(route('admin'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.admin');
    }

    public function test_user_index_page_is_accessible()
    {
        $response = $this->get(route('admin.user-index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.user-index');
    }

    public function test_show_user_details()
    {
        $user = User::factory()->create();
        $user->profile()->create([
            'postcode' => '9876543',
            'address' => 'Osaka, Namba',
            'building' => 'Namba Building',
        ]);
        $response = $this->get(route('admin.show', $user->id));

        $response->assertStatus(200);
        $response->assertJson([
            'user' => $user->toArray(),
            'profile' => $user->profile->toArray(),
        ]);
    }

    public function test_destroy_user()
    {
        $user = User::factory()->create();
        Profile::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('admin.delete', $user->id));

        $response->assertRedirect(route('admin.user-index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('profiles', ['user_id' => $user->id]);
    }

    public function test_index_page_displays_items_with_comments()
    {
        $item = Item::factory()->create();
        Comment::factory()->create(['item_id' => $item->id]);

        $response = $this->get(route('admin.comments'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.comments');
        $response->assertSee($item->name);
    }

    public function test_notify_mail_page_is_accessible()
    {
        $response = $this->get(route('admin.notify'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.notify');
    }

    public function test_send_email_notifications()
    {
        $users = User::factory()->count(3)->create();

        Mail::fake();

        $response = $this->post(route('admin.notify.send'), [
            'subject' => 'テストメール',
            'message' => 'このメールはテストです。',
        ]);

        $response->assertRedirect(route('admin.notify'));
        $response->assertSessionHas('success', 'メールの送信に成功しました。');

        Mail::assertQueued(NotifyMail::class, 3);
    }

    public function test_destroy_comment()
    {
        $item = Item::factory()->create();
        $comment = Comment::factory()->create(['item_id' => $item->id]);

        $response = $this->delete(route('admin.destroy.comment', [$item->id, $comment->id]));

        $response->assertRedirect(route('admin.comments'));
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
