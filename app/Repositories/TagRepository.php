<?php

namespace App\Repositories;

use App\Tag;

class TagRepository
{
  protected $tag;

	public function __construct(Tag $tag)
	{
	    $this->tags = $tag;
	}
    /**
    *
    * @return Collection
    */
    public function getAllTags()
    {
        return $this->tags->orderBy('created_at', 'asc')->get();
    }
}