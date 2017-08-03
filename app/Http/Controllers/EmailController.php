<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\ApplicationEmail;
use Illuminate\Support\Facades\Redirect;

class EmailController extends Controller
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

    public function index()
    {
        $this->authorize('access-admin');
        return view('settings.emails.index', ['emails' => ApplicationEmail::all()]);
    }

    public function editEmail($id)
    {
        $this->authorize('access-admin');

        return view('settings.emails.edit', ['email' => ApplicationEmail::findOrFail($id)]);
    }

    public function storeEmail(Request $request, $id)
    {
        $this->authorize('access-admin');

        $this->validate($request, [
            'description'  => 'required|max:255',
            'subject'      => 'required|max:255',
            'body'         => 'required|max:2500'
        ]);

        $email = ApplicationEmail::findOrFail($id);
        $email->update($request->all());

        return Redirect::route('emails::edit', ['id' => $id])->with('status', ['type' => 'success', 'message' => 'Email saved.']);
    }
}
