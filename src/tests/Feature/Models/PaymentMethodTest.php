<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\PaymentMethod;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_payment_method()
    {
        $paymentMethod = PaymentMethod::create(['name' => 'Credit Card']);

        $this->assertDatabaseHas('payment_methods', [
            'id' => $paymentMethod->id,
            'name' => 'Credit Card',
        ]);
    }
}
