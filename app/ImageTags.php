<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageTags extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_id','tag_id'
    ];
}
