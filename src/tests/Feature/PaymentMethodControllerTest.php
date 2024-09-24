<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Item;
use App\Models\SoldItem;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentMethodControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_access_payment_method_edit_page()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->get(route('payment.method.edit', $item->id));

        $response->assertStatus(200);
        $response->assertViewIs('payment-method');
        $response->assertViewHas('paymentMethod');
    }

    public function test_user_can_update_payment_method()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create(['id' => 2, 'name' => 'コンビニ払い']);

        $response = $this->actingAs($user)->post(route('payment.method.update', ['item' => $item->id]), [
            'payment_method_id' => $paymentMethod->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('sold_items', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
        ]);
    }

    public function test_invalid_payment_method_is_rejected()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('payment.method.update', $item->id), [
            'payment_method_id' => 9999,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('payment_method_id');
    }

    public function test_guest_cannot_access_payment_method_edit_page()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('payment.method.edit', $item->id));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }
}
