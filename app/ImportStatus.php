<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImportStatus extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'import_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total', 'completed'
    ];
}
