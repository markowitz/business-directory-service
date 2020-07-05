<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'user_type' => 'super_admin',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Admin',
                'email' => 'icnwakanma@gmail.com',
                'user_type' => 'admin',
                'password' => Hash::make('password'),
            ]

        ]);
    }
}
