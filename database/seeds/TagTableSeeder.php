<?php

use Illuminate\Database\Seeder;
use App\Tag;
use Illuminate\Support\Facades\Hash;
class TagTableSeeder extends Seeder{

    public function run()
    {
        DB::table('tags')->delete();
        Tag::create(array(
            'name' => 'tag_1'
        ));
    }

}