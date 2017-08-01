<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'candidate_id'];


    public function candidate()
    {
        return $this->belongsTo('App\Candidate');
    }

    /**
     * Set the state's description.
     *
     * @param  string  $value
     * @return string
     */
    public function setMessage($value)
    {
        //clean with html purifier
        $this->attributes['message'] = clean($value);
    }
}
