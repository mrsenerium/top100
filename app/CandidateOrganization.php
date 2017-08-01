<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateOrganization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'candidate_id', 'organization_id', 'name', 'description', 'position_held', 'involvement_length', 'involvement_duration', 'organization_type'
    ];

    public function candidate()
    {
        return $this->belongsTo('App\Candidate', 'id', 'candidate_id');
    }
}
