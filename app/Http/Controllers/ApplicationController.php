<?php

namespace App\Http\Controllers;

use App\ApplicationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CandidateOrganization;
use App\CandidateResponse;
use App\Candidate;
use App\Http\Requests\CandidateApplicationRequest;
use App\User;
use config\Auth;

class ApplicationController extends Controller
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

    public function getForm()
    {
        $candidate = request()->user()->candidate;
        $this->authorize('submit-application', $candidate);
        return view('application.form', ['candidate' => $candidate]);
    }

    public function storeForm(CandidateApplicationRequest $request)
    {
        $candidate = request()->user()->candidate;
        $this->authorize('submit-application', $candidate);

        $candidateApp = CandidateResponse::firstOrNew(['id' => $candidate->id]);
        $candidateApp->additional_majors = $request->additional_majors;
        $candidateApp->academic_honors = $request->academic_honors;
        $candidateApp->reflection = $request->reflection;
        $candidateApp->submitted = $request->confirm === 'on' ? true : false;
        $candidateApp->save();

        //save services and activities
        CandidateOrganization::where('candidate_id', $candidate->id)->delete();
        $count = 0;
        foreach ($request->service as $service) {
            if(!empty($service['name'])) {
                $candidate->organizations()->create([
                    'candidate_id'          => $candidate->id,
                    'organization_id'       => $count,
                    'name'                  => $service['name'],
                    'description'           => $service['description'],
                    'position_held'         => $service['position_held'],
                    'involvement_length'    => $service['involvement'],
                    'involvement_duration'  => $service['duration'],
                    'organization_type'     => 'service'
                ]);
                $count++;
            }
        }
        foreach ($request->activity as $activity) {
            if(!empty($activity['name'])) {
                $candidate->organizations()->create([
                    'candidate_id'          => $candidate->id,
                    'organization_id'       => $count,
                    'name'                  => $activity['name'],
                    'description'           => $activity['description'],
                    'position_held'         => $activity['position_held'],
                    'involvement_length'    => $activity['involvement'],
                    'involvement_duration'  => $activity['duration'],
                    'organization_type'     => 'activity'
                ]);
                $count++;
            }
        }

        //if the confirmation is checked, user is submitting final application
        if($candidateApp->submitted === true) {
            $mail = ApplicationEmail::find(ApplicationEmail::ApplicationSubmitted);
            \Mail::queue('emails.applications.confirmation', [
                'candidate'     => $candidate,
                'body'          => $mail->body,
                'response'      => $candidateApp,
                'services'      => $candidate->organizations()->where('organization_type', 'service')->get(),
                'activities'    => $candidate->organizations()->where('organization_type', 'activity')->get()
            ], function ($message) use($candidate, $mail) {
                $message->to($candidate->user->email);
                $message->subject($mail->subject);
            });

            return Redirect::route('application::view')->with('status', ['type' => 'success', 'message' => 'Application submitted.']);
        }

        //if user pressed preview, redirect to view page
        if(isset($request->preview_app))
            return Redirect::route('application::view')->with('status', ['type' => 'success', 'message' => 'Application saved.']);

        return Redirect::route('application::form')->with('status', ['type' => 'success', 'message' => 'Application saved.']);
    }

    public function updateForm(CandidateApplicationRequest $request)
    {
        $candidate = Candidate::findOrFail($request->id);
        $this->authorize('create-candidates');

        $candidateApp = CandidateResponse::firstOrNew(['id' => $candidate->id]);
        $candidateApp->additional_majors = $request->additional_majors;
        $candidateApp->academic_honors = $request->academic_honors;
        $candidateApp->reflection = $request->reflection;

        //save services and activities
        CandidateOrganization::where('candidate_id', $candidate->id)->delete();
        $count = 0;
        foreach ($request->service as $service) {
            if(!empty($service['name'])) {
                $candidate->organizations()->create([
                    'candidate_id'          => $candidate->id,
                    'organization_id'       => $count,
                    'name'                  => $service['name'],
                    'description'           => $service['description'],
                    'position_held'         => $service['position_held'],
                    'involvement_length'    => $service['involvement'],
                    'involvement_duration'  => $service['duration'],
                    'organization_type'     => 'service'
                ]);
                $count++;
            }
        }
        foreach ($request->activity as $activity) {
            if(!empty($activity['name'])) {
                $candidate->organizations()->create([
                    'candidate_id'          => $candidate->id,
                    'organization_id'       => $count,
                    'name'                  => $activity['name'],
                    'description'           => $activity['description'],
                    'position_held'         => $activity['position_held'],
                    'involvement_length'    => $activity['involvement'],
                    'involvement_duration'  => $activity['duration'],
                    'organization_type'     => 'activity'
                ]);
                $count++;
            }
        }

        //if user pressed cancel, redirect to all
        if(isset($request->cancel_save))
        {
            return Redirect::route('candidates::index')->with('status', ['type' => 'success', 'message' => 'Save Cancelled.']);
        }
        else
        {
          $candidateApp->save();
        }
        return Redirect::route('application::view', ['id'=>$candidate->id])->with('status', ['type' => 'success', 'message' => 'Application saved.']);
    }

    public function viewApplication($id = null)
    {
        if(isset($id))
            $candidate = Candidate::findOrFail($id);
        else
            $candidate = request()->user()->candidate;
        $this->authorize('view-application', $candidate);
        //if the candidate has no application, show 404 page
        if(!$candidate->application)
            abort(404, 'Candidate application not found.');
        return view('application.view', ['candidate' => $candidate, 'id' => $id]);
    }

    public function adminEditApplication($id = null)
    {
        if(isset($id))
            $candidate = Candidate::findOrFail($id);
        else
            $candidate = request()->user()->candidate;

        $this->authorize('edit-users');

        //if the candidate has no application, show 404 page
        if(!$candidate->application)
            abort(404, 'Candidate application not found.');

        return view('application.editForm', ['candidate' => $candidate]);
    }
}
