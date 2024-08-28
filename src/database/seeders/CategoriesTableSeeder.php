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
        $fashion = DB::table('categories')->insertGetId(['name' => 'ファッション']);
        $gamesToysGoods = DB::table('categories')->insertGetId(['name' => 'ゲーム・おもちゃ・グッズ']);
        $booksMagazinesComics = DB::table('categories')->insertGetId(['name' => '本・雑誌・漫画']);
        $smartphonesTabletsComputers = DB::table('categories')->insertGetId(['name' => 'スマホ・タブレット・パソコン']);
        $foodBeveragesAlcohol = DB::table('categories')->insertGetId(['name' => '食品・飲料品・酒']);

        DB::table('categories')->insert([
            ['name' => 'メンズ', 'parent_id' => $fashion],
            ['name' => 'レディース', 'parent_id' => $fashion],
            ['name' => 'キッズ', 'parent_id' => $fashion],
        ]);

        DB::table('categories')->insert([
            ['name' => 'ゲーム', 'parent_id' => $gamesToysGoods],
            ['name' => 'おもちゃ', 'parent_id' => $gamesToysGoods],
            ['name' => 'グッズ', 'parent_id' => $gamesToysGoods],
        ]);

        DB::table('categories')->insert([
            ['name' => '本', 'parent_id' => $booksMagazinesComics],
            ['name' => '雑誌', 'parent_id' => $booksMagazinesComics],
            ['name' => '漫画', 'parent_id' => $booksMagazinesComics],
        ]);

        DB::table('categories')->insert([
            ['name' => 'スマホ', 'parent_id' => $smartphonesTabletsComputers],
            ['name' => 'タブレット', 'parent_id' => $smartphonesTabletsComputers],
            ['name' => 'パソコン', 'parent_id' => $smartphonesTabletsComputers],
        ]);

        DB::table('categories')->insert([
            ['name' => '食品', 'parent_id' => $foodBeveragesAlcohol],
            ['name' => '飲料品', 'parent_id' => $foodBeveragesAlcohol],
            ['name' => '酒', 'parent_id' => $foodBeveragesAlcohol],
        ]);

    }
}
