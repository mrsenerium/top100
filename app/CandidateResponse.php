<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateResponse extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'reflection', 'additional_majors', 'academic_honors', 'submitted'
    ];

    /**
     * Set the state's description.
     *
     * @param  string  $value
     * @return string
     */
    public function setReflection($value)
    {
        //clean with html purifier
        $this->attributes['reflection'] = clean($value);
    }

    public function candidate()
    {
      return $this->belongsTo('App\Candidate', 'id', 'id');
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'submitted' => 'boolean'
    ];
}
