<?php

namespace App\Services;

use App\Candidate;
use Cache;
use AppSettings;
use App\Round2Score;
use App\Round1Score;
use Spatie\Permission\Models\Role;

class ScoringService
{
    public function assignJudges()
    {
        Round1Score::truncate();
        $roles = Role::where('name', 'LIKE', 'judge 1%')->get();
        $candidates = Candidate::submitted()->get()->shuffle();
        foreach ($roles as $role) {
            $judges = \App\User::whereHas('roles', function ($query) use($role) {
                $query->where('id', $role->id);
            })->get()->shuffle();
            $judgeArray = new \ArrayObject($judges->toArray());
            $iterator = $judgeArray->getIterator();
            $total = $candidates->count();
            $index = 0;
            $counter = 0;
            //hard code to assign each candidate to two of each type,
            //if there is only one judge in a category, they must be assigned to all
            $max = min($judges->count(), 2);
            while($index < $total) {
                if($iterator->valid()) {
                    $candidates[$index]->round1Scores()->create([
                        'judge_id'  => $iterator->current()['id']
                    ]);
                    $iterator->next();
                    if(++$counter % $max == 0) {
                        $index++;
                    }
                }
                else {
                    $iterator->rewind();
                }
            }
        }
    }

    public function getTop100($orderByScore = true, $paginate = false)
    {
        //get all top100 candidates
        $candidates = Candidate::top100();

        //order $candidates
        if($orderByScore)
            $candidates->orderBy('round1_score', 'desc');
        else
            $candidates->inRandomOrder();//->orderByName();  To Fix "Readers Fatiuge"

        if($paginate === true)
            return $candidates->paginate(10);
        return $candidates->get();
    }

    public function calculateTop100()
    {
        $topNum = 100;
        // $results = array();
        $this->calculateScores(1);
        $candidates = Candidate::submitted()->orderBy('round1_score', 'desc')->get();

        $count = 1;
        $lastScore = 0;
        foreach ($candidates as $candidate) {
            //skip those who have no score;
            //this be could caused by a judge with a score who was removed and
            //no other judges have scored yet
            if($candidate->round1_score == 0)
                continue;

            if($count <= $topNum) {
                $candidate->update([
                    'top100'    => true
                ]);
                $lastScore = $candidate->round1_score;
                $count++;
            }
            else if ($count > $topNum && $lastScore == $candidate->round1_score) {
                $candidate->update([
                    'top100'    => true
                ]);
            }
            else {
                break;
            }
        }
    }

    public function calculateRound2()
    {
        $this->calculateScores(2);
    }

    public function getRound2($orderByScore = true, $paginate = true)
    {
      $candidates = Round2Score::ByJudge();
      return $candidates;
    }

    public function getRound2Totals($orderByScore = true, $paginate = true)
    {
      //get all top100 candidates
      //$candidates = Candidate::top100();

      //$candidates = Round2Score::with('Judge')->orderBy('candidate_id', 'asc')->get();

      //order $candidates
      $candidates = Candidate::top100();

      //order $candidates
      if($orderByScore)
          $candidates->orderBy('round2_score', 'desc');
      else
          $candidates->inRandomOrder();//->orderByName();  To Fix "Readers Fatiuge"

      if($paginate === true)
          return $candidates->paginate(10);
      return $candidates->get();
    }

    private function calculateScores($round = 1)
    {
        if($round == 1) {
            //reset scores
            \DB::table('candidates')->update([
                'round1_score'  => 0,
                'top100'    => false
            ]);
            Candidate::with('round1Scores')->submitted()->chunk(50, function ($candidates) {
                foreach ($candidates as $candidate) {
                    $this->calculateRound1Score($candidate);
                }
            });
        }
        if($round == 2) {
            //reset scores
            \DB::table('candidates')->update([
                'round2_score'  => 0
            ]);
            $candidates = Candidate::submitted()->where('top100', true)->get();
            foreach ($candidates as $candidate) {
                $this->calculateRound2Score($candidate);
            }
        }
    }

    private function calculateRound1Score(Candidate $candidate)
    {
        $scores = $candidate->round1Scores->reject(function ($value, $key) {
            // //get required, non-disqualified candidate total for judge
            // $required = Round1Score::required($value->judge_id)->count();
            // //get total number of completed scores
            // $judged = Round1Score::required($value->judge_id)->where(function ($query) {
            //     $query->whereNotNull('reflection_score')
            //         ->orWhereNotNull('academics_score')
            //         ->orWhereNotNull('activities_score')
            //         ->orWhereNotNull('services_score');
            // })->count();
            $unjudged = Round1Score::required($value->judge_id)->where(function ($query) {
                $query->whereNull('reflection_score')
                    ->orWhereNull('academics_score')
                    ->orWhereNull('activities_score')
                    ->orWhereNull('services_score');
            })->count();
            return $unjudged > 0;
            // //if more required than judged, remove score
            // return $required > $judged;
        });
        $totals = $scores->map(function($item, $key) {
            return $item->academics_score + $item->reflection_score + $item->services_score + $item->activities_score;
        });
        $candidate->update([
            'round1_score'  => $totals->avg()
        ]);
        return $candidate->round1_score;
    }

    private function calculateRound2Score(Candidate $candidate)
    {
        $scores = $candidate->round2Scores->reject(function ($value, $key) {
            $NumberInTop100 = count($this->getTop100());
            $required = $NumberInTop100;     //TODO: make setting
            $judged = Round2Score::where('judge_id', $value->judge_id)->count();
            //die(var_dump($NumberInTop100));
            return $required > $judged;
        });
        if(!$scores)
            return 0;
        $scores = $candidate->round2Scores->reject(function ($value, $key) {
            // //get required, non-disqualified candidate total for judge
            // $required = Round1Score::required($value->judge_id)->count();
            // //get total number of completed scores
            // $judged = Round1Score::required($value->judge_id)->where(function ($query) {
            //     $query->whereNotNull('reflection_score')
            //         ->orWhereNotNull('academics_score')
            //         ->orWhereNotNull('activities_score')
            //         ->orWhereNotNull('services_score');
            // })->count();
            $unjudged = Round2Score::required($value->judge_id)->where(function ($query) {
                $query->whereNull('reflection_score')
                    ->orWhereNull('academics_score')
                    ->orWhereNull('activities_score')
                    ->orWhereNull('services_score');
                    //->orWhereNull('recommendations_score');
            })->count();
            return $unjudged > 0;
            // //if more required than judged, remove score
            // return $required > $judged;
        });
        $totals = $scores->map(function($item, $key) {
            return $item->academics_score + $item->reflection_score + $item->services_score + $item->activities_score + $item->recommendations_score;
        });
        $candidate->update([
            'round2_score'  => $totals->sum()
        ]);
        return $candidate->round2_score;
    }

}
