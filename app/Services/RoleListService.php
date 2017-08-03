<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleListService
{
    public function all()
    {
        $roles = Role::all();
        return $roles->sortBy('name');
    }
}
