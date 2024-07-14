<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
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
            'condition' => '新品・未使用',
        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '2',
            'condition' => '非常に良好',
        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '3',
            'condition' => '良好',
        ];
        DB::table('conditions')->insert($param);

        $param = [
            'id' => '4',
            'condition' => '可',
        ];
        DB::table('conditions')->insert($param);
    }
}
