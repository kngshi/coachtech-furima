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
        'name' => 'admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('admin1234'),
        'role' => '1',
        ];

        DB::table('users')->insert($param);

        $param = [
        'id' => '2',
        'name' => 'sample_user',
        'email' => 'sample@example.com',
        'password' => bcrypt('sample1234'),
        'role' => '2',
        ];

        DB::table('users')->insert($param);

        $param = [
        'id' => '3',
        'name' => 'sample_user2',
        'email' => 'sample2@example.com',
        'password' => bcrypt('sample1234'),
        'role' => '2',
        ];

        DB::table('users')->insert($param);

        $param = [
        'id' => '4',
        'name' => 'sample_user3',
        'email' => 'sample3@example.com',
        'password' => bcrypt('sample1234'),
        'role' => '2',
        ];

        DB::table('users')->insert($param);
    }
}
