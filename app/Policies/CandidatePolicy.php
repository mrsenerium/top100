<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\User;
use App\Candidate;
use App\ApplicationStates;
use App\ApplicationSettings;
use AppSettings;

class CandidatePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Candidate $candidate)
    {
        return $user->id === $candidate->user_id;
    }

    public function submitApplication(User $user, Candidate $candidate)
    {
        $currentState = AppSettings::getCurrentState();
        //if the state is nominations & applications or applications only
        if($currentState == ApplicationStates::ApplicationsOnly || $currentState == ApplicationStates::Nominations) {
            //if the user id === the candidate user id
            if($user->id == $candidate->user_id) {
                //if the candidate has been nominated and is not disqualified
                if(!$candidate->disqualified && $candidate->nominated) {
                    //if the application is new or has not been submitted
                    if(is_null($candidate->application) || !$candidate->application->submitted)
                        return true;    //allow access
                }
            }
        }
        return false;
    }

    public function viewApplication (User $user, Candidate $candidate)
    {
        return $user->can('view-candidates') || $user->id == $candidate->user_id;
    }

    // // There must be a better way to do this
    // public function viewRecommendations(User $user, Candidate $candidate)
    // {
    //     return $user->can('view-candidates') && $user->id != $candidate->user_id;
    // }

    public function beNominated(User $user, Candidate $candidate)
    {
        return $user->can('nominate') && !$candidate->disqualified;// && $user->id != $candidate->user_id;
    }

    public function participateRound2(User $user, Candidate $candidate)
    {
        $currentState = AppSettings::getCurrentState();
        //if round 2 is open, guests lists can be made
        if($currentState == ApplicationStates::Round2Open) {
            return $user->id == $candidate->user_id && $candidate->top100;
        }
        return false;
    }
}
