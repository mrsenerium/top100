<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Candidate extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'user_id'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
    }

    public function scopeForJudge($query, $id)
    {
        return $query->whereHas('round1Scores', function($q) use($id) {
            return $q->where('judge_id', $id);
        });
    }

    /**
     * Scope a query to only include valid candidates who have submitted applications.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSubmitted($query)
    {
        return $query->where([
            ['nominated', true],
            ['disqualified', false]
        ])
        //find only candidates who have submitted applications
        ->whereExists(function ($q) {
            $q->select(DB::raw(1))
                ->from('candidate_responses')
                ->whereRaw('candidate_responses.id = candidates.id AND candidate_responses.submitted = 1');
        });
    }

    /**
     * Scope a query order by candidate's name.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByName($query)
    {
        return $query->join('users', 'candidates.user_id', '=', 'users.id')
                     ->orderBy('users.lastname')
                     ->orderBy('users.firstname')
                     //select candidates
                     ->select('candidates.*');
    }

    /**
     * Scope a query to return top 100 candidates only
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTop100($query)
    {
        return $query->submitted()->where('top100', true);
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    public function application()
    {
        return $this->hasOne('App\CandidateResponse', 'id', 'id');
    }

    public function organizations()
    {
        return $this->hasMany('App\CandidateOrganization', 'candidate_id', 'id');
    }

    public function round1Scores()
    {
        return $this->hasMany('App\Round1Score', 'candidate_id', 'id');
    }

    public function round2Scores()
    {
        return $this->hasMany('App\Round2Score', 'candidate_id', 'id');
    }

    public function recommendations()
    {
      return $this->hasMany('App\Recommendation', 'candidate_id', 'id');
    }

    public function guests()
    {
        return $this->hasMany('App\Guest', 'candidate_id', 'id');
    }

    /**
     * Get full name of candidate
     *
     * @return    string
     */
    public function getFullNameAttribute()
    {
        return $this->user->firstname.' '.$this->user->lastname;
    }

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'nominated' => 'boolean',
        'disqualified' => 'boolean',
        'top100'    => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['fullname'];

}
