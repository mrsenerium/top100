<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'username', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeJudges($query, $round)
    {
        return $query->whereHas('roles', function ($q) use($round) {
            $q->where('name', 'LIKE', "judge $round%");
        });
    }

    public function candidate()
    {
        return $this->hasOne('App\Candidate');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->username;
    }

    public function isSuperAdmin()
    {
        //TODO: check if user is super admin
        return true;
    }
}
