<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
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
            'user_id' => '2',
            'item_id' => '1',
            'comment' => 'これはテスト用コメントです。',
        ];

        DB::table('comments')->insert($param);

        $param = [
            'id' => '2',
            'user_id' => '2',
            'item_id' => '2',
            'comment' => 'これはテスト用コメントです。',
        ];

        DB::table('comments')->insert($param);

        $param = [
            'id' => '3',
            'user_id' => '2',
            'item_id' => '3',
            'comment' => 'これはテスト用コメントです。',
        ];

        DB::table('comments')->insert($param);

        $param = [
            'id' => '4',
            'user_id' => '2',
            'item_id' => '1',
            'comment' => 'これはテスト用コメントです。',
        ];

        DB::table('comments')->insert($param);
    }
}
