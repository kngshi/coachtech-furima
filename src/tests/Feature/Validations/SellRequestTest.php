<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;

class SellRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testSellRequestValidation()
    {
        Condition::factory()->create([
            'condition' => 'New'
        ]);

        $parentCategory = Category::factory()->create(['parent_id' => null]);
        $childCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);

        $data = [
            'name' => 'Sample Item',
            'brand' => 'Sample Brand',
            'price' => 1000,
            'description' => 'This is a sample item description.',
            'img_url' => UploadedFile::fake()->image('test.jpg'),
            'condition_id' => Condition::first()->id,
            'parent_category' => $parentCategory->id,
            'category' => [],
        ];

        $response = $this->post('/sell', $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'category' => '少なくとも1つの子カテゴリを選択してください。',
        ]);
    }

    public function testValidSellRequest()
    {
        Condition::factory()->create([
            'condition' => 'New'
        ]);

        $parentCategory = Category::factory()->create(['parent_id' => null]);
        $childCategory = Category::factory()->create(['parent_id' => $parentCategory->id]);

        $data = [
            'name' => 'Sample Item',
            'brand' => 'Sample Brand',
            'price' => 1000,
            'description' => 'This is a sample item description.',
            'img_url' => UploadedFile::fake()->image('test.jpg'),
            'condition_id' => Condition::first()->id,
            'parent_category' => $parentCategory->id,
            'category' => [$childCategory->id],
        ];

        $response = $this->post('/sell', $data);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }
}
