<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
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
            'name' => 'ファッション',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'ゲーム・おもちゃ・グッズ',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '3',
            'name' => '本・雑誌・漫画',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '4',
            'name' => 'スマホ・タブレット・パソコン',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '5',
            'name' => '食品・飲料品・酒',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'id' => '6',
            'name' => 'キッチン・日用品・その他',
        ];
        DB::table('categories')->insert($param);

    }
}
