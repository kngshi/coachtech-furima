<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Profile;
use App\Models\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_profile_belongs_to_a_user()
    {
        $profile = Profile::factory()->create();

        $this->assertInstanceOf(User::class, $profile->user);
    }

    public function test_has_fillable_attributes()
    {
        $profile = new Profile();

        $this->assertEquals([
            'user_id',
            'img_url',
            'postcode',
            'address',
            'building',
        ], $profile->getFillable());
    }
}
