<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
        public function run()
    {
        DB::table('category_items')->insert([
            'item_id' => 1,
            'category_id' => 6,
        ]);

        DB::table('category_items')->insert([
            'item_id' => 2,
            'category_id' => 10,
        ]);

        DB::table('category_items')->insert([
            'item_id' => 3,
            'category_id' => 12,
        ]);

        DB::table('category_items')->insert([
            'item_id' => 4,
            'category_id' => 18,
        ]);

        DB::table('category_items')->insert([
            'item_id' => 5,
            'category_id' => 15,
        ]);
    }
}
