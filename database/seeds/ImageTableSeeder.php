<?php

use Illuminate\Database\Seeder;
use App\Image;
use Illuminate\Support\Facades\Hash;
class ImageTableSeeder extends Seeder{

    public function run()
    {
        DB::table('images')->delete();
        Image::create(array(
            'name' => 'test',
            'path' => 'storage/images',
            'ext' => 'png',
            'published' => '1'
        ));
    }

}