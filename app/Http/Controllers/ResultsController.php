<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ScoringService as Scoring;
use Illuminate\Support\Facades\Redirect;

class ResultsController extends Controller
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

    public function showTop100(Scoring $scoring)
    {
        $this->authorize('access-admin');

        return view('results.top100', ['results' => $scoring->getTop100(true, true)]);
    }

    public function showRound2(Scoring $scoring)
    {
        $this->authorize('access-admin');

        return view('results.round2', ['results' => $scoring->getRound2()]);
    }

    public function calculate(Request $request, Scoring $scoring)
    {
        $this->authorize('access-admin');

        if($request->has('round')) {
            if($request->round == 1) {
                $scoring->calculateTop100();
                return Redirect::back()->with('status', ['type' => 'success', 'message' => 'Round 1 results calculated.']);
            }

            if($request->round == 2) {
                $scoring->calculateRound2();
                return Redirect::back()->with('status', ['type' => 'success', 'message' => 'Round 2 results calculated.']);
            }
        }

        return Redirect::back()->with('status', ['type' => 'danger', 'message' => 'Results not calculated.']);
    }
}
