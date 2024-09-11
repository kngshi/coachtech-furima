<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;


class ProfileRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_requires_name()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->post('/mypage/profile', [
            'postcode' => '1234567',
            'address' => 'Some Address',
            'building' => 'Some Building',
        ]);

        $response->assertStatus(302)
                 ->assertSessionHasErrors('name');
    }

    public function test_requires_postcode_to_be_string_and_max_10_characters()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->post('/mypage/profile', [
            'name' => 'John Doe',
            'postcode' => 12345678901, // 11桁の郵便番号
            'address' => 'Some Address',
            'building' => 'Some Building',
        ]);

        $response->assertStatus(302)
                 ->assertSessionHasErrors('postcode');
    }

    public function test_allows_valid_data()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->post('/mypage/profile', [
            'name' => 'John Doe',
            'postcode' => '1234567',
            'address' => 'Some Address',
            'building' => 'Some Building',
        ]);

        $response->assertStatus(302)
                 ->assertSessionHas('success', 'プロフィールを更新しました。');
    }

    public function test_allows_image_upload()
    {
        $user = User::factory()->create();

        Auth::login($user);

        Storage::fake('s3');

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->post('/mypage/profile', [
            'name' => 'John Doe',
            'postcode' => '1234567',
            'address' => 'Some Address',
            'building' => 'Some Building',
            'img_url' => $file,
        ]);

        Storage::disk('s3')->assertExists('users/' . $file->hashName());

        $response->assertStatus(302)
                 ->assertSessionHas('success', 'プロフィールを更新しました。');
    }
}
