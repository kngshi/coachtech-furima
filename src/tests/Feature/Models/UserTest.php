<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_user_with_fillable_attributes()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password123'),
            'role' => '2',
        ]);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john.doe@example.com', $user->email);
        $this->assertTrue(\Hash::check('password123', $user->password));
        $this->assertEquals('2', $user->role);
    }

    public function test_has_a_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($profile->id, $user->profile->id);
        $this->assertEquals($profile->img_url, $user->profile->img_url);
        $this->assertEquals($profile->postcode, $user->profile->postcode);
        $this->assertEquals($profile->address, $user->profile->address);
        $this->assertEquals($profile->building, $user->profile->building);
    }
}
