<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('access-admin');
        
        return view('admin.index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getReset()
    {
        $this->authorize('access-admin');

        return view('admin.reset');
    }

    public function postReset(Request $request)
    {
        $this->authorize('access-admin');

        $this->validate($request, [
            'confirm'   => 'required'        //txt mimetype seems to be required for csv to work
        ], [
            'confirm.required' => 'You must verify you understand all deleted data will be permanently lost.'
        ]);

        \App\User::has('candidate')->delete();

        return Redirect::route('admin::index')->with('status', ['type' => 'success', 'message' => 'Application successfully reset. Candidates have been deleted.']);
    }
}
