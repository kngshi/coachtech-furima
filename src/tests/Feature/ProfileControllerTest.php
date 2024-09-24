<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // S3の仮想ストレージを設定
        Storage::fake('s3');
    }

    /** @test */
    public function it_can_show_edit_profile_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('edit.profile'));

        $response->assertStatus(200);
        $response->assertViewIs('profile');
        $response->assertViewHas('user_id', $user->id);
    }

    /** @test */
    public function it_can_store_profile()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'New Name',
            'postcode' => '123-4567',
            'address' => 'Tokyo, Japan',
            'building' => 'Building A',
            'img_url' => UploadedFile::fake()->image('avatar.jpg'),
        ];

        $response = $this->post(route('profile.store'), $data);

        $response->assertRedirect(route('mypage', ['user_id' => $user->id]));
        $response->assertSessionHas('success', 'プロフィールを更新しました。');

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postcode' => '123-4567',
            'address' => 'Tokyo, Japan',
            'building' => 'Building A',
        ]);

        Storage::disk('s3')->assertExists('users/' . $data['img_url']->hashName());
    }

    /** @test */
    public function it_can_show_edit_address_page()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('edit.address', $item->id));

        $response->assertStatus(200);
        $response->assertViewIs('address');
        $response->assertViewHas('profile', $profile);
        $response->assertViewHas('item', $item);
    }

    /** @test */
    public function it_can_update_address()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);
        $item = Item::factory()->create();

        $this->actingAs($user);

        $data = [
            'postcode' => '987-6543',
            'address' => 'Osaka, Japan',
            'building' => 'Building B',
        ];

        $response = $this->put(route('update.address', $item->id), $data);


        $response->assertRedirect(route('purchase.info', $item->id));
        $response->assertSessionHas('success', '住所が更新されました');

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postcode' => '987-6543',
            'address' => 'Osaka, Japan',
            'building' => 'Building B',
        ]);
    }
}

