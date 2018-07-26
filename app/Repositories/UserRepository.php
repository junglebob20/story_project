<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
  protected $user;

	public function __construct(User $user)
	{
	    $this->users = $user;
	}
    /**
    *
    * @return Collection
    */
    public function getAllUsers()
    {
        return $this->users->orderBy('created_at', 'asc')->get();
    }
}