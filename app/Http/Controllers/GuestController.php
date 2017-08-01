<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Guest;
use Redirect;
use Excel;

class GuestController extends Controller
{
    public function admin()
    {
        $this->authorize('access-admin');

        return view('guests.admin', ['guests' => Guest::paginate()]);
    }

    public function export()
    {
        $this->authorize('access-admin');
        $filename = 'top100.guests-'.\Carbon\Carbon::now()->toDateTimeString();
        Excel::create($filename, function ($excel) {
            $data = Guest::with('candidate')->get()->map(function ($item) {
                return [
                    'names'         => $item->name->implode(', '),
                    'address'       => $item->address,
                    'phone'         => $item->phone,
                    'relationship'  => $item->relationship,
                    'guest of'      => $item->candidate->fullname
                ];
            });

            $excel->sheet('Export', function ($sheet) use($data) {
                $sheet->fromArray($data);
                $sheet->setAutoSize(true);
            });
        })->export('xlsx');
    }

    public function manage()
    {
        $this->authorize('create-guest-list');
        $candidate = Candidate::where('user_id', auth()->user()->id)->first();
        $this->authorize('participate-round2', $candidate);

        return view('guests.manage', ['candidate' => $candidate, 'guests' => $candidate->guests]);
    }

    public function add(Request $request)
    {
        $this->authorize('create-guest-list');
        $candidate = Candidate::where('user_id', auth()->user()->id)->first();
        $this->authorize('participate-round2', $candidate);

        //TODO: validate
        $this->validate($request, [
            'address'       => 'required|max:255',
            'phone'         => 'required|max:255',
            'name.0'        => 'required',
            'relationship'  => 'required|max:255'
        ], [
            'name.0.required' =>  'You must enter at least one guest in this household.'
        ]);

        $candidate->guests()->create($request->all());

        return Redirect::back()->with('status', ['type' => 'success', 'message' => 'Guest added.']);
    }

    public function delete(Request $request, $id)
    {
        $this->authorize('create-guest-list');
        $candidate = Candidate::where('user_id', auth()->user()->id)->first();
        $this->authorize('participate-round2', $candidate);

        Guest::destroy($id);
        return Redirect::back()->with('status', ['type' => 'success', 'message' => 'Guest deleted.']);
    }
}
