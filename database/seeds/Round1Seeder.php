<?php

use Illuminate\Database\Seeder;

class Round1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 400)->create()->each(function ($user) {
            $candidate = factory(App\Candidate::class)->make([
                    'nominated' => true,
                    'disqualified'  => false
                ]);
            $user->candidate()->save($candidate);
            $response = factory(App\CandidateResponse::class)->make();
            $candidate->application()->save($response);
            for ($i=0; $i < 5; $i++) {
                $org = factory(App\CandidateOrganization::class)->make([
                    'organization_id' => $i+1
                ]);
                $candidate->organizations()->save($org);
            }
        });
    }
}
