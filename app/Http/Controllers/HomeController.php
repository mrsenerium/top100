<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\ApplicationStates;
use Illuminate\Http\Request;
use AppSettings;

class HomeController extends Controller
{
    protected $currentState;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->currentState = ApplicationStates::find(AppSettings::getCurrentState());
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('home', ['current_state' => $this->currentState]);
    }
}
