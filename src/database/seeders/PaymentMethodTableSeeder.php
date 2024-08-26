<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodTableSeeder extends Seeder
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
            'name' => 'クレジットカード',
        ];

        DB::table('payment_methods')->insert($param);

        $param = [
            'id' => '2',
            'name' => 'コンビニ払い',
        ];

        DB::table('payment_methods')->insert($param);

        $param = [
            'id' => '3',
            'name' => '銀行振込',
        ];

        DB::table('payment_methods')->insert($param);
    }
}
