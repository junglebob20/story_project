<?php

namespace App\Repositories;

use App\Image;

class ImageRepository
{
  protected $image;

	public function __construct(Image $image)
	{
	    $this->images = $image;
	}
    /**
    *
    * @return Collection
    */
    public function getAllImages()
    {
        return $this->images->orderBy('created_at', 'asc')->get();
    }
}