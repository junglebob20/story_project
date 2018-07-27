<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Role extends Model
{
    public function users()
    {
        return $this->belongsTo('App\Role', 'users_role','user_id','role_id');
    }
}
