<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Round2Score extends CompositeBaseModel
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'round2_scores';

    protected $primaryKey = 'candidate_id';
    protected $secondaryKey = 'judge_id';

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
      'candidate_id', 'judge_id', 'academics_score', 'reflection_score', 'services_score', 'activities_score', 'recommendations_score'
    ];

    public function scopeRequired($query, $judge_id)
    {
        return $query->where('judge_id', $judge_id)->whereHas('candidate', function ($subquery) {
            $subquery->where('disqualified', false);
        });
    }

    public function judge()
    {
        return $this->belongsTo('App\User', 'judge_id');
    }

    public function candidate()
    {
        return $this->belongsTo('App\Candidate', 'candidate_id');
    }

    public function hasScores()
    {
        return isset($this->academics_score) && isset($this->reflection_score) && isset($this->services_score) && isset($this->activities_score);
    }

    public function total()
    {
        if($this->hasScores())
            return $this->academics_score + $this->reflection_score + $this->services_score + $this->activities_score + $this->recommendations_score;
    }
}
