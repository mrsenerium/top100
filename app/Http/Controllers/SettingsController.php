<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\ApplicationStates;
use AppSettings;

class SettingsController extends Controller
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


    public function showApplicationSettings()
    {
        $this->authorize('access-admin');
        return view('settings.application', [
          'states' => ApplicationStates::all()->pluck('name', 'id')->all()  //don't know why calling all after pluck returns the right thing (https://laravel.com/docs/5.2/collections#method-pluck)
        ]);
    }

    public function storeApplicationSettings(Request $request)
    {
        $this->authorize('access-admin');
        $this->validate($request, [
            'reflection_question'   => 'required|max:255',
            'current_state'         => 'required',
            'separate_genders'      => 'required|boolean',
            'organization_max'      => 'required|integer|min:0'
        ]);

        $previousState = AppSettings::getCurrentState();

        AppSettings::setReflectionQuestion($request->reflection_question);
        AppSettings::setOrganizationMax($request->organization_max);
        AppSettings::setSeparateGenders($request->separate_genders);
        AppSettings::setCurrentState($request->current_state);
        AppSettings::save();

        return Redirect::route('settings::application')->with('status', ['type' => 'success', 'message' => 'Settings saved.']);
    }

    public function showApplicationStates()
    {
        $this->authorize('access-admin');
        return view('settings.states', [
          'states' => ApplicationStates::all()
        ]);
    }

    public function getApplicationState($id)
    {
        $this->authorize('access-admin');
        return view('settings.states.edit', ['state' => ApplicationStates::findOrFail($id)]);
    }

    public function storeApplicationState($id, Request $request)
    {
        $this->authorize('access-admin');
        $this->validate($request, [
            'description'       => 'required|max:2000',
            'help_text'         => 'max:2000',
            'end_date'          => 'date'
        ]);

        ApplicationStates::findOrFail($id)->update($request->all());

        return Redirect::route('settings::state.get', ['id' => $id])->with('status', ['type' => 'success', 'message' => 'States saved.']);
    }
}
