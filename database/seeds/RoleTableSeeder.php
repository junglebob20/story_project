<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder{

    public function run()
    {
        DB::table('roles')->delete();
        Role::create(array(
            'name' => 'Root'
        ));
        Role::create(array(
            'name' => 'Admin'
        ));
        Role::create(array(
            'name' => 'User'
        ));
    }

}