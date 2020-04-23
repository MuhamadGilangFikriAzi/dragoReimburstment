<?php

use Carbon\Carbon;
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
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@mail.com',
            'password' => bcrypt('123456'),
            'created_at' => Carbon::now(),
        ]);
    }
}
