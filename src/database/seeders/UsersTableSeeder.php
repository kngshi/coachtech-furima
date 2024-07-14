<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
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
        'name' => 'sample_user',
        'email' => 'sample@example.com',
        'password' => bcrypt('sample1234'),
        ];

        DB::table('users')->insert($param);

        $param = [
        'id' => '2',
        'name' => 'sample_user2',
        'email' => 'saple2@example.com',
        'password' => bcrypt('sample1234'),
        ];

        DB::table('users')->insert($param);
    }
}
