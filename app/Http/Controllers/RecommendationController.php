<?php

namespace App\Http\Controllers;

use App\ApplicationEmail;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\ScoringService;
use App\Recommendation;
use App\Candidate;
use Illuminate\Support\Facades\Redirect;


class RecommendationController extends Controller
{
    public function index(ScoringService $scoring)
    {
        //authorize; passing in 'anonymous' as user to bypass user
        //requirement for auth policies - this feels like a terrible way to do this
        $this->authorizeForUser('anonymous', 'recommend');

        return view('recommendations.search');
    }

    public function search(Request $request, ScoringService $scoring)
    {
        $this->authorizeForUser('anonymous', 'recommend');

        $this->validate($request, [
            'search'                => 'required|string|min:3'
        ]);

        $search = explode(' ', $request->search);

        //intersect multiple terms
        $users;
        foreach ($search as $term) {
            $temp = User::where('firstname', 'like', '%'.$term.'%')
                        ->orWhere('lastname', 'like', '%'.$term.'%')
                        ->orWhere('email', 'like', '%'.str_replace('@butler.edu', '', $term).'@butler.edu');
            if(!isset($users))
                $users = $temp->get();
            else {
                $users = $users->intersect($temp->get());
            }
        }

        $ids = $users->pluck('id');

        $candidates = Candidate::Top100()->orderByName()->whereIn('candidates.user_id', $ids)->get();

        return view('recommendations.results', ['candidates' => $candidates]);
    }

    public function getForm($id)
    {
        //authorize
        //TODO: prevent candidate from recommending self
        $this->authorizeForUser('anonymous', 'recommend');

        $candidate = Candidate::findOrFail($id);
        return view('recommendations.form', ['candidate' => $candidate]);
    }

    public function storeForm(Request $request, $id)
    {
        //authorize
        //TODO: prevent candidate from recommending self
        $this->authorizeForUser('anonymous', 'recommend');

        $this->validate($request, [
            'recommender_name'      => 'required|string|max:255',
            'recommender_email'     => 'required|email|max:255',
            'recommendation_body'   => 'required|string|max:20000'
        ]);

        $candidate = Candidate::findOrFail($id);

        $recommendation = new Recommendation([
            'name'      => $request->recommender_name,
            'email'     => $request->recommender_email,
            'message'   => $request->recommendation_body
        ]);

        $candidate->recommendations()->save($recommendation);
        //dd(config('mail.driver'));
        // //send confirmation email to recommender
        $mail = ApplicationEmail::find(ApplicationEmail::RecommendationConfirmation);
        \Mail::queue('emails.recommendations.user-confirmation', [
            'recommender'    => $recommendation->name,
            'candidate'         => $candidate,
            'body'              => $mail->body
        ], function ($message) use($recommendation, $mail) {
            $message->to($recommendation->email);
            $message->subject($mail->subject);
        });


        //send confirmation email to candidate
        $mail = ApplicationEmail::find(ApplicationEmail::CandidateRecommendationConfirmation);
        \Mail::queue('emails.recommendations.student-confirmation', [
            'candidate'     => $candidate,
            'body'          => $mail->body,
            'recommender'   => $recommendation->name
        ], function ($message) use($candidate, $mail) {
            $message->to($candidate->user->email);
            $message->subject($mail->subject);
        });


        return Redirect::route('recommendations::index')->with('status', [
            'type' => 'success',
            'message' => 'Your recommendation for '.$candidate->fullname.' was saved.'
        ]);
    }

    public function request()
    {
        //TODO: authorize
        $candidate = Candidate::where('user_id', auth()->user()->id)->first();
        $this->authorize('participate-round2', $candidate);

        return view('recommendations.request');
    }

    public function emailRequest(Request $request)
    {
        //TODO: authorize
        $candidate = Candidate::where('user_id', auth()->user()->id)->first();
        $this->authorize('participate-round2', $candidate);

        $this->validate($request, [
            'recommender_name'  => 'required|string',
            'recommender_email' => 'required|email',
            'request_body'      => 'required|string'
        ]);

        $mail = ApplicationEmail::find(ApplicationEmail::RecommendationRequest);
        $email = $request->recommender_email;
        \Mail::queue('emails.recommendations.request', [
            'request'           => $request->all(),
            'candidate'         => $candidate,
            'body'              => $mail->body,
            'recommendation_url'    => route('recommendations::recommend', ['id' => $candidate->id])
        ], function ($message) use($email, $mail) {
            $message->to($email);
            $message->subject($mail->subject);
        });

        return Redirect::route('recommendations::request')->with('status', [
            'type' => 'success',
            'message' => 'Your recommendation request was sent to '.$request->recommender_name.' at '.$request->recommender_email.'.'
        ]);
    }

    public function adminEdit($id, $cid)
    {
        //authorize
        //TODO: prevent candidate from recommending self
        $this->authorize('edit-users');
        $candidate = Candidate::findOrFail($cid);
        $recommendation = Recommendation::findOrFail($id);
        return view('recommendations.editForm', ['recommendation' => $recommendation, 'candidate' => $candidate]);
    }

    public function adminStoreForm(Request $request, $id, $cid)
    {
        //authorize
        //TODO: prevent candidate from recommending self
        $this->authorize('edit-users');

        $this->validate($request, [
            'recommender_name'      => 'required|string|max:255',
            'recommender_email'     => 'required|email|max:255',
            'recommendation_body'   => 'required|string|max:20000'
        ]);

        $candidate = Candidate::findOrFail($cid);
        $recommendation = Recommendation::findOrFail($id);
        $recommendation->name = $request->recommender_name;
        $recommendation->email = $request->recommender_email;
        $recommendation->message = $request->recommendation_body;

        $candidate->recommendations()->save($recommendation);

        return Redirect::route('application::view', ['id' => $candidate->id])->with('status', [
            'type' => 'success',
            'message' => 'The recommendation for '.$candidate->fullname.' was saved.'
        ]);
    }
}
