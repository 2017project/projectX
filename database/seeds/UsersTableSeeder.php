<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'thanhchung',
                'email' => 'thanhchung@gmail.com',
                'password' => bcrypt('123456'),
                'first_name' => 'Bui',
                'middle_name' => 'Thanh',
                'last_name' => 'Chung',
            ],
            [
                'username' => 'longnt',
                'email' => 'longnt@gmail.com',
                'password' => bcrypt('123456'),
                'first_name' => 'Nguyen',
                'middle_name' => 'Thanh',
                'last_name' => 'Long',
            ],
            [
                'username' => 'test',
                'email' => 'test@gmail.com',
                'password' => bcrypt('123456'),
                'first_name' => 'Nguyen',
                'middle_name' => 'Van',
                'last_name' => 'Test',
            ],
        ];

        foreach ($users as $user) {
            \Illuminate\Support\Facades\DB::table('users')->insert($user);
        }
    }
}