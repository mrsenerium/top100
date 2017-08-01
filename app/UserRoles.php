<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    $incrementing = false;
    $primaryKey = ['user_id', 'role_id'];
}
