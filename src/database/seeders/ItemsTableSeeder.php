<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $param = [
            'id' => '1',
            'name' => 'sample商品',
            'brand' => 'COACHTECH',
            'price' => '1000',
            'description' => 'これはsample商品です',
            'img_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
            'user_id' => '1',
            'condition_id' => '2',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'sample商品2',
            'brand' => 'COACHTECH',
            'price' => '1200',
            'description' => 'これはsample商品2です',
            'img_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
            'user_id' => '1',
            'condition_id' => '1',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '3',
            'name' => 'sample商品3',
            'brand' => 'COACHTECH',
            'price' => '1500',
            'description' => 'これはsample商品3です',
            'img_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
            'user_id' => '1',
            'condition_id' => '3',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '4',
            'name' => 'sample商品4',
            'brand' => 'COACHTECH',
            'price' => '1800',
            'description' => 'これはsample商品4です',
            'img_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
            'user_id' => '1',
            'condition_id' => '3',
        ];
        DB::table('items')->insert($param);
    }
}
