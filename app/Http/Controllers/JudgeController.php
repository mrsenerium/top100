<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Candidate;
use App\Round1Score;
use App\Round2Score;
use App\Services\ScoringService as Scoring;
use Illuminate\Support\Facades\DB;

class JudgeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getRound1()
    {
        //authorize
        $this->authorize('round1-judging');

        //need to use join query to order by candidate's name
        $candidates = Candidate::submitted()->forJudge(auth()->user()->id)->orderByName()->get();

        return view('judging.round1', ['candidates' => $candidates]);
    }

    public function getRateForm($candidateid)
    {
        //authorize
        $this->authorize('round1-judging');

        $candidate = Candidate::findOrFail($candidateid);

        $score = Round1Score::firstOrCreate(['candidate_id' => $candidateid, 'judge_id' => auth()->user()->id]);
        return view('judging.rate', ['candidate' => $candidate, 'score' => $score]);
    }

    public function storeRateForm(Request $request, $candidateid)
    {
        //authorize
        $this->authorize('round1-judging');

        $this->validate($request, [
            'academics_score'       => 'required|integer',
            'reflection_score'      => 'required|integer',
            'activities_score'      => 'required|integer',
            'services_score'        => 'required|integer'
        ]);

        $score = Round1Score::firstOrCreate(['candidate_id' => $candidateid, 'judge_id' => auth()->user()->id]);

        $score->academics_score = $request->academics_score;
        $score->reflection_score = $request->reflection_score;
        $score->activities_score = $request->activities_score;
        $score->services_score = $request->services_score;
        $score->save();
        echo(var_dump($score->candidate->user));
        return Redirect::route('judging::round1')->with('status', [
            'type' => 'success',
            'message' => 'Applicant scores saved' //.$score->candidate->user->firstname.' '.$score->candidate->user->lastname.'.'
        ]);
    }

    public function getRound2()
    {
      //authorize
      $this->authorize('round2-judging');

      //need to use join query to order by candidate's name
      $candidates = Candidate::submitted()->forJudge(auth()->user()->id)->orderByName()->get();

      return view('judging.round2', ['candidates' => $candidates]);
    }

    public function getRound2RateForm($candidateid = null)
    {
        //authorize
        $this->authorize('round2-judging');

        $candidate = Candidate::findOrFail($candidateid);

        $score = Round1Score::firstOrCreate(['candidate_id' => $candidateid, 'judge_id' => auth()->user()->id]);
        return view('judging.rate2', ['candidate' => $candidate, 'score' => $score]);
    }

    public function storeRound2(Request $request)
    {
        //authorize
        $this->authorize('round2-judging');

        $judge_id = auth()->user()->id;
        Round2Score::where('judge_id', $judge_id)->delete();
        $selected = $request->input('selected');
        foreach ($selected as $index => $candidate_id) {
            Round2Score::create([
                'candidate_id'  => $candidate_id,
                'judge_id'      => $judge_id,
                'rank_position' => 25 - $index
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Ranking saved successfully.']);
    }

    public function assign(Request $request, Scoring $scoring)
    {
        $this->authorize('access-admin');
        $scoring->assignJudges();

        return Redirect::back()->with('status', ['type' => 'success', 'message' => 'Round 1 judges assigned to candidates.']);
    }
}
