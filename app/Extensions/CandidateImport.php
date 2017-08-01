<?php

namespace App\Extensions;

use Storage;

class CandidateImport extends \Maatwebsite\Excel\Files\ExcelFile
{
    //TODO: make these configurable?
    // protected $delimiter  = ',';
    // protected $enclosure  = '"';
    // protected $lineEnding = '\r\n';

    public function getFile()
    {
        Storage::delete('private/import.csv');
        request()->file('import')->move(storage_path('app/private'), 'import.csv');
        return storage_path('app/private/import.csv');
    }

    public function getFilters()
    {
        return [
            'chunk'
        ];
    }
}
