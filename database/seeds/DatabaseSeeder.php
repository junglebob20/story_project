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
        $this->call(UserTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(ImageTableSeeder::class);
        $this->call(ImageTagsTableSeeder::class);
        $this->call(RoleTableSeeder::class);
    }
}
