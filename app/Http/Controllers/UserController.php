<?php

namespace App\Http\Controllers;

use App\Round1Score;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
        $this->authorize('view-users');
        $users = User::has('roles')->orderBy('lastname')->orderBy('firstname')->paginate(10); //exclude
        return view('users.index', ['users' => $users]);
    }

    public function edit($id)
    {
        $this->authorize('edit-users');
        $user = User::findOrFail($id);

        return view('users.edit', ['user' => $user]);
    }

    public function save(UserEditRequest $request, $id)
    {
        $this->authorize('edit-users');
        $user = User::findOrFail($id);

        //save values
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        if(!empty($request->password))
            $user->password = bcrypt($request->password);

        $user->save();

        $roles = Role::all();
        foreach ($roles as $role) {
            //if role is selected
            if(collect($request->roles)->contains($role->id)) {
                //if the user does not currently have the selected role, assign role to user
                if(!$user->hasRole(Role::find($role->id)))
                    $user->assignRole($role);
            }
            else {
                //prevent removing admin role from self
                if($request->user()->id == $id && $user->hasRole('admin') && $role->name == 'admin') {
                    //provide message / visual feedback to user; TODO: allow multiple status messages?
                    $warning = [
                        'type' => 'warning',
                        'message' => 'User saved successfully with warnings:<br /><strong>Admin</strong> role cannot be removed from current user.'
                    ];
                    continue;
                }

                //remove unselected roles from user
                $user->removeRole($role);

                if($role->name == 'judge 2') {
                    \App\Round2Score::where('judge_id', $id)->delete();
                }
            }
        }
        //find any round 1 juding roles assigned to user
        $userJudge1Roles = $user->roles()->pluck('name')->filter(function ($value, $key) {
            return strpos($value, 'judge 1') !== false;
        });
        //if the user does not have any round 1 judging roles, delete round 1 scores
        if($userJudge1Roles->count() === 0) {
            \App\Round1Score::where('judge_id', $id)->delete();
        }


        if(isset($warning))
            return Redirect::route('users::index')->with('status', $failure);

        return Redirect::route('users::index')->with('status', ['type' => 'success', 'message' => 'User saved.']);
    }

    public function add()
    {
        $this->authorize('create-users');
        return view('users.add');
    }

    public function saveNew(UserRequest $request)
    {
        $this->authorize('create-users');

        $user = User::firstOrNew(['username' => $request->username]);

        //if a user exists with roles already assigned, they are not new
        if($user->exists && $user->roles()->count() > 0) {
            $link = route('users::edit', ['id' => $user->id]);
            return Redirect::route('users::add')->with('status', [
                'type' => 'danger',
                'message' => "The user $user->username already exists. You must <a href=\"$link\">edit $user->username</a> to make changes to this user."
            ]);
        }

        //save new user
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->username = $request->username;

        $user->password = bcrypt($request->password);
        if($request->email == $request->username.'@butler.edu' && empty($request->password)) {
            //generate random password for ldap users; they should only authenticate via ldap
            $user->password = bcrypt(str_random(36));
        }

        $user->save();

        //assign roles to user
        foreach ($request->roles as $roleID) {
            $role = Role::find($roleID);
            $user->assignRole($role->name);
        }

        return Redirect::route('users::index')->with('status', ['type' => 'success', 'message' => 'User added successfully.']);
    }

    public function delete($id)
    {
        $this->authorize('delete-users');
        if(request()->user()->id == $id) {
            return Redirect::route('users::index')->with('status', [
                'type' => 'danger',
                'message' => "The current user may not be deleted. To delete this account, you must login as different user with admin rights."
            ]);
        }
        User::find($id)->delete();
        return Redirect::back()->with('status', ['type' => 'success', 'message' => 'User deleted successfully.']);
    }

    public function judges()
    {
        $this->authorize('view-users');
        $round1Judges = User::judges(1)->orderBy('lastname')->orderBy('firstname')->get();
        $judgesMap = $round1Judges->map(function ($item) {
            $scores = Round1Score::where('judge_id', '=', $item->id);
            return [
                'user'          => $item,
                'totalAssigned' => $scores->count(),
                'totalJudged'   => $scores->where('academics_score', '!=', null)
                                    ->where('reflection_score', '!=', null)
                                    ->where('activities_score', '!=', null)
                                    ->where('services_score', '!=', null)->count()
            ];
        });
        $data['round1'] = $judgesMap;

        $round2Judges = User::judges(2)->orderBy('lastname')->orderBy('firstname')->get();
        $judgesMap = $round2Judges->map(function ($item) {
            $scores = \App\Round2Score::where('judge_id', '=', $item->id);
            return [
                'user'          => $item,
                'totalRequired' => 25,
                'totalJudged'   => $scores->count()
            ];
        });
        $data['round2'] = $judgesMap;

        return view('users.judges', $data);
    }
}
