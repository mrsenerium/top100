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
      'candidate_id', 'judge_id', 'rank_position'
    ];

    public function judge()
    {
      return $this->belongsTo('App\User', 'judge_id');
    }

    public function candidate()
    {
      return $this->belongsTo('App\Candidate', 'candidate_id');
    }
}
