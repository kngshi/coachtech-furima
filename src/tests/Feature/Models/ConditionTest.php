<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Condition;
use App\Models\Item;

class ConditionTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_condition()
    {
        $condition = Condition::create(['condition' => 'New']);

        $this->assertDatabaseHas('conditions', [
            'condition' => 'New',
        ]);
    }

    public function test_has_items()
    {
        $condition = Condition::create(['condition' => 'New']);
        $item = Item::factory()->create(['condition_id' => $condition->id]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'condition_id' => $condition->id,
        ]);

    }
}
