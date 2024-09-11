<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;

class UpdateAddressRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_address_with_valid_data()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $item = Item::factory()->create();

        $response = $this->put(route('update.address', $item->id), [
            'postcode' => '1234567890',
            'address' => 'Test Address',
            'building' => 'Test Building',
        ]);

        $response->assertRedirect(route('purchase.info', $item->id));

        $this->assertDatabaseHas('profiles', [
            'user_id' => $user->id,
            'postcode' => '1234567890',
            'address' => 'Test Address',
            'building' => 'Test Building',
        ]);
    }

    public function test_update_address_with_invalid_data()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $item = Item::factory()->create();

        $response = $this->put(route('update.address', $item->id), [
            'postcode' => '',
            'address' => '',
        ]);

        $response->assertSessionHasErrors(['postcode', 'address']);
    }
}