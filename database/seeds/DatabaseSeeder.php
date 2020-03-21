<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //define which files are seeds
         $this->call(UsersTableSeeder::class);
         $this->call(RolesTableSeeder::class);
    }
}
