<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\ImportStatus;

class ImportController extends Controller
{
    public function form()
    {
        $this->authorize('create-candidates');

        $status = ImportStatus::find(1);
        if (isset($status)) {
            if ($status->total > $status->completed) {
                return view('import.status', ['percentage' => ($status->completed / $status->total) * 100]);
            }
        }
        return view('import.form');
    }

    public function upload(Requests\ImportFileRequest $request, \App\Extensions\CandidateImport $importer)
    {
        $this->authorize('create-candidates');

        ImportStatus::destroy(1);
        $importer->handleImport();

        return view('import.status', []);
        //return Redirect::action('CandidateController@import')->with('status', ['type' => 'success', 'message' => 'Candidates imported successfully.']);
    }

    public function status()
    {
        return ImportStatus::find(1);
    }
}
