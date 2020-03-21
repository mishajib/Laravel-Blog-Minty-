<?php

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

        //insert default value into users table
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'mishajib222@gmail.com',
            'password' => bcrypt('i am back'),
        ]);

        DB::table('users')->insert([
            'role_id' => '2',
            'name' => 'Author',
            'username' => 'author',
            'email' => 'author@blog.com',
            'password' => bcrypt('author'),
        ]);
    }
}
