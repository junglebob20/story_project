<?php

use Illuminate\Database\Seeder;
use App\ImageTags;
use Illuminate\Support\Facades\Hash;
class ImageTagsTableSeeder extends Seeder{

    public function run()
    {
        DB::table('image_tags')->delete();
        ImageTags::create(array(
            'image_id' => '0',
            'tag_id' => '0'
        ));
    }

}