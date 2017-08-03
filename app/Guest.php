<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Guest extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'candidate_id', 'created_at', 'updated_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    public function setNameAttribute($value)
    {
        //remove empty items from array
        $this->attributes['name'] = collect($value)->reject(function ($item) {
            return empty($item);
        });
    }

    public function candidate()
    {
        return $this->hasOne('App\Candidate', 'id', 'candidate_id');
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'collection'
    ];
}
