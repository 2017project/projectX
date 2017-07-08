<?php

use Illuminate\Database\Seeder;

class MailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

        $mails = [
            "sender_id" => 1
        ];

        foreach ($users as $user) {
            \Illuminate\Support\Facades\DB::table('users')->insert($user);
        }
    }
}