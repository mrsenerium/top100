<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationEmail extends Model
{
    const Nomination = 1;
    const NominationConfirmation = 2;
    const ApplicationSubmitted = 3;
    const RecommendationRequest = 4;
    const RecommendationConfirmation = 5;
    const CandidateRecommendationConfirmation = 6;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['description', 'subject', 'body'];

    /**
     * Set the state's description.
     *
     * @param  string  $value
     * @return string
     */
    public function setBody($value)
    {
        //clean with html purifier
        $this->attributes['body'] = clean($value);
    }
}
