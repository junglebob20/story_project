<?php

namespace App\Repositories;

use App\Role;

class RoleRepository
{
  protected $role;

	public function __construct(Role $role)
	{
	    $this->roles = $role;
	}
    /**
    *
    * @return Collection
    */
    public function getAllRoles()
    {
        return $this->roles->get();
    }
}