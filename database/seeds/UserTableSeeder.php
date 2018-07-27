<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UserTableSeeder extends Seeder{

    public function run()
    {
        DB::table('users')->delete();
        User::create(array(
            'username' => 'root',
            'password' => Hash::make('root'),
            'remember_token' => '0'
        ));
    }

}