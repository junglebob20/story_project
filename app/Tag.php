<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Image;
use Kyslik\ColumnSortable\Sortable;
class Tag extends Model
{
    use Sortable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','published'
    ];
    public function images()
    {
        return $this->belongsToMany(Image::Class, 'image_tags', 'image_id', 'tag_id');
    }
    public $sortable = ['id','name','created_at','updated_at'];
}
