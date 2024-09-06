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
            'name' => 'sample商品(メンズ服)
            ',
            'brand' => 'COACHTECH',
            'price' => '1000',
            'description' => 'これはsample商品（メンズ服）です',
            'img_url' => 'https://coachtech-furima-sim-bucket.s3.ap-northeast-1.amazonaws.com/items/s2CCkyqhKwQ89vbwGbFVIIN7OqhNmsSqXn2asyOS.png',
            'user_id' => '2',
            'condition_id' => '2',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'sample商品2（おもちゃ）',
            'brand' => 'COACHTECH',
            'price' => '1200',
            'description' => 'これはsample商品2（おもちゃ）です',
            'img_url' => 'https://coachtech-furima-sim-bucket.s3.ap-northeast-1.amazonaws.com/items/66qvcQCYtuQ6t73yORGjQHfpMggEaia3MMWlXpug.png',
            'user_id' => '2',
            'condition_id' => '1',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '3',
            'name' => 'sample商品3（本）',
            'brand' => 'COACHTECH',
            'price' => '1500',
            'description' => 'これはsample商品3（本）です',
            'img_url' => 'https://coachtech-furima-sim-bucket.s3.ap-northeast-1.amazonaws.com/items/yNu6hWqyamMuj2prochz8NzuiK3SaKIoNnzaY3oS.png',
            'user_id' => '2',
            'condition_id' => '3',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '4',
            'name' => 'sample商品4（レモン）',
            'brand' => 'COACHTECH',
            'price' => '1800',
            'description' => 'これはsample商品4（レモン）です',
            'img_url' => 'https://coachtech-furima-sim-bucket.s3.ap-northeast-1.amazonaws.com/items/l6QPG48uVjAuaHqDAZSzdmGrCZUHOq4IY1B36B8D.png',
            'user_id' => '2',
            'condition_id' => '1',
        ];
        DB::table('items')->insert($param);

        $param = [
            'id' => '5',
            'name' => 'sample商品5',
            'brand' => 'COACHTECH',
            'price' => '1800',
            'description' => 'これはsample商品5です',
            'img_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
            'user_id' => '3',
            'condition_id' => '2',
        ];
        DB::table('items')->insert($param);
    }
}
