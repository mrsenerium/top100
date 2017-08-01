<?php

namespace App\Http\Controllers;

use App\ApplicationEmail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CandidateUserRequest;
use Illuminate\Support\Facades\Redirect;
use App\Candidate;
use Excel;
use App\User;

class CandidateController extends Controller
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

    public function index(Request $request)
    {
        $this->authorize('view-candidates');
        $this->authorize('access-admin');

        $query = Candidate::with('user', 'round1Scores', 'round2Scores', 'application');

        if($request->has('nominated')) {
            $nominated = $request->input('nominated');
            if($nominated != 'all')
                $query->where('nominated', $nominated === 'true');
        }

        if($request->has('disqualified')) {
            $disqualified = $request->input('disqualified');
            if($disqualified != 'all')
                $query->where('disqualified', $disqualified === 'true');
        }

        if($request->has('top100')) {
            $top100 = $request->input('top100');
            if($top100 != 'all')
                $query->where('top100', $top100 === 'true');
        }

        if($request->has('submitted')) {
            $submitted = $request->input('submitted');
            if($submitted != 'all') {
                if($submitted === 'true') {
                    $query->whereHas('application', function ($subquery) {
                            $subquery->where('submitted', true);
                    });
                }
                else {
                    $query->where(function ($wherequery) {
                        $wherequery->whereDoesntHave('application')->orWhereHas('application', function ($subquery) {
                            $subquery->where('submitted', false);
                        });
                    });
                }
            }
        }

        if($request->has('search')) {
            $search = $request->input('search');
            $search = explode(' ', $search);
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
            $query->whereIn('candidates.user_id', $ids);
        }

        $query->orderByName();

        $perPage = 25;
        if($request->has('perPage'))
            $perPage = $request->input('perPage');
        $candidates = $query->paginate($perPage);

        return view('candidates.index', ['candidates' => $candidates->appends($request->except('page'))]);
    }

    public function export()
    {
        $this->authorize('view-candidates');
        $this->authorize('access-admin');

        $filename = 'top100.candidates-'.\Carbon\Carbon::now()->toDateTimeString();
        Excel::create($filename, function ($excel) {
            $data = Candidate::with('user')->orderByName()->get()->map(function ($item) {
                return [
                    'lastname'      => $item->user->lastname,
                    'firstname'     => $item->user->firstname,
                    'email'         => $item->user->email,
                    'nominated'     => $item->nominated === true ? 'true' : 'false',
                    'disqualified'  => $item->disqualified === true ? 'true' : 'false',
                    'submitted'     => ($item->application && $item->application->submitted) ? 'true' : 'false',
                    'college'       => $item->college,
                    'major'         => $item->major,
                    'class'         => $item->class == 40 ? 'Senior' : 'Junior',
                    'total hours'   => $item->total_hours,
                    'round 1 score' => $item->round1_score,
                    'top 100'       => $item->top100 === true ? 'true' : 'false',
                    'round 2 score' => $item->round2_score,
                ];
            });

            $excel->sheet('Export', function ($sheet) use($data) {
                $sheet->fromArray($data);
                $sheet->setAutoSize(true);
            });
        })->export('xlsx');
    }

    public function edit($id)
    {
        $this->authorize('edit-candidates');
        $candidate = Candidate::findOrFail($id);

        return view('candidates.edit', ['candidate' => $candidate]);
    }

    public function save(CandidateUserRequest $request, $id)
    {
        $this->authorize('edit-candidates');
        $candidate = Candidate::findOrFail($id);

        $user_fields = $request->only(['firstname', 'lastname']);
        $candidate->user()->update($user_fields);

        $candidate_fields = $request->except(['firstname', 'lastname', 'submitted']);
        $candidate->update($candidate_fields);

        if($candidate->has('application'))
        {
            $candidate->application()->update([
                'submitted' => $request->submitted
            ]);
        }

        return Redirect::route('candidates::index')->with('status', ['type' => 'success', 'message' => 'Candidate saved.']);
    }

    public function add()
    {
        $this->authorize('create-candidates');
        return view('candidates.add');
    }

    public function saveNew(CandidateUserRequest $request)
    {
        $this->authorize('create-candidates');

        $user = User::firstOrNew(['username' => $request->username]);

        //if a user exists with roles already assigned, they are not new
        if($user->exists && $user->candidate) {
            $link = route('candidate::edit', ['id' => $user->candidate->id]);
            return Redirect::route('candidates::add')->with('status', [
                'type' => 'danger',
                'message' => "The user $user->username already exists. You must <a href=\"$link\">edit $user->username</a> to make changes to this user."
            ]);
        }

        //save new user
        $user->firstname    = $request->firstname;
        $user->lastname     = $request->lastname;
        $user->email        = $request->email;
        $user->username     = $request->username;
        $user->password     = bcrypt(str_random(36));

        $user->save();

        $candidate_fields = $request->except(['firstname', 'lastname', 'email', 'username']);
        //create new candidate
        $user->candidate()->save(new Candidate($candidate_fields));

        return Redirect::route('candidates::index')->with('status', ['type' => 'success', 'message' => 'Candidate added successfully.']);
    }

    public function nominate()
    {
        $this->authorize('nominate');
        return view('candidates.nominations.search');
    }

    public function searchCandidates(Request $request)
    {
        $this->authorize('nominate');

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

        $candidates = Candidate::orderByName()
                        ->whereIn('candidates.user_id', $ids)
                        ->where('candidates.disqualified', 0)   //find candidates that are not disqualified
                        ->get();

        return view('candidates.nominations.results', ['candidates' => $candidates]);
    }

    public function saveNominee($id)
    {
        $currentUser = auth()->user();
        $candidate = Candidate::findorFail($id);
        if($currentUser->candidate()->exists() && $currentUser->candidate->id == $id) {
            return Redirect::route('candidates::nominate')->with('status', ['type' => 'danger', 'message' => 'You may not nominate yourself.']);
        }

        //only set nominated to true once; but give people the illusion of nominating
        if(!$candidate->nominated) {
            $candidate->nominated = true;
            $candidate->save();
            //send email to nominated candidate;
            $mail = ApplicationEmail::find(ApplicationEmail::Nomination);
            \Mail::queue('emails.nominations.student-confirmation', [
                'candidate' => $candidate,
                'body'      => $mail->body
            ], function ($message) use($candidate, $mail) {
                $message->to($candidate->user->email);
                $message->subject($mail->subject);
            });
        }

        //send email to nominator; currently logged-in user
        $mail = ApplicationEmail::find(ApplicationEmail::NominationConfirmation);
        \Mail::queue('emails.nominations.user-confirmation', [
            'candidate' => $candidate,
            'user'      => $currentUser,
            'body'      => $mail->body
        ], function ($message) use($currentUser, $mail) {
            $message->to($currentUser->email);
            $message->subject($mail->subject);
        });

        $message = $candidate->user->firstname.' '.$candidate->user->lastname.' has been nominated!';
        return Redirect::route('candidates::nominate')->with('status', ['type' => 'success', 'message' => $message]);
    }
}
