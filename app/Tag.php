<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Image;
class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];
    public function images()
    {
        return $this->belongsToMany(Image::Class, 'image_tags', 'image_id', 'tag_id');
    }
}
