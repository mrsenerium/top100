<?php

namespace App\Extensions;

use App\User;
use App\Candidate;
use App\Extensions\CandidateImport;

class CandidateImportHandler implements \Maatwebsite\Excel\Files\ImportHandler
{

    public function handle($import)
    {
        // get the results (excluding file)
        $headings = request()->except('import');
        $total = count($import->all());

        //\Log::debug('total to import', ['total' => $total]);

        $import->chunk(25, function ($results) use ($headings, $total) {
            foreach ($results as $row) {
                //find or create new user
                $user = User::firstOrNew(['username' => $row->{$this->formatHeading($headings['username_heading'])}]);

                try {
                    //set user values
                    $user->firstname = $row->{$this->formatHeading($headings['firstname_heading'])};
                    $user->lastname = $row->{$this->formatHeading($headings['lastname_heading'])};
                    $user->email = $row->{$this->formatHeading($headings['email_heading'])};
                    //generate random password for ldap users; they should only authenticate via ldap
                    $user->password = bcrypt(str_random(24));

                    $user->save();

                    //find candidate
                    $candidate = $user->candidate;
                    if (is_null($candidate)) {
                        $candidate = new Candidate();
                        $user->candidate()->save($candidate);
                    }
                    $candidate->update([
                        'gender'        => $row->{$this->formatHeading($headings['gender_heading'])},
                        'college'       => $row->{$this->formatHeading($headings['college_heading'])},
                        'major'         => $row->{$this->formatHeading($headings['major_heading'])},
                        'class'         => $row->{$this->formatHeading($headings['class_heading'])},
                        'total_hours'   => $row->{$this->formatHeading($headings['hours_heading'])},
                        'gpa'           => $row->{$this->formatHeading($headings['gpa_heading'])}
                    ]);
                } catch (\PDOException $e) {
                    //TODO: log candidates that could not be imported to DB to display to user
                    \Log::error('Error importing user.', ['user' => $user->toArray(), 'exception' => $e->getMessage()]);
                }
            }
            event(new \App\Events\CandidatesImported($total, count($results)));
        });
    }

    protected function formatHeading($heading)
    {
        return str_slug(strtolower($heading));
    }
}
