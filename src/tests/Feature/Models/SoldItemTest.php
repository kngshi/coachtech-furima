<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\SoldItem;
use App\Models\User;

class SoldItemTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_sold_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create();

        $soldItem = SoldItem::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
        ]);

        $this->assertDatabaseHas('sold_items', [
            'id' => $soldItem->id,
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
        ]);
    }

    public function test_belongs_to_an_item()
    {
        $soldItem = SoldItem::factory()->create();
        $this->assertInstanceOf(Item::class, $soldItem->item);
    }

    public function test_belongs_to_a_payment_method()
    {
        $soldItem = SoldItem::factory()->create();
        $this->assertInstanceOf(PaymentMethod::class, $soldItem->paymentMethod);
    }
}
