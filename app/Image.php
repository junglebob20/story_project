<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tag;
class Image extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name','path','ext','published'
    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::Class, 'image_tags', 'image_id', 'tag_id');
    }
    public $sortable = ['id','name'];
}
