<?php

use App\Round1Score;
use App\ApplicationStates;
use App\Services\ScoringService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        factory(App\User::class, 50)->create()->each(function ($user) {
            $candidate = factory(App\Candidate::class)->make();
            $user->candidate()->save($candidate);
            if($candidate->nominated && !$candidate->disqualified) {
                $response = factory(App\CandidateResponse::class)->make();
                $candidate->application()->save($response);
                for ($i=0; $i < 5; $i++) {
                    $org = factory(App\CandidateOrganization::class)->make([
                        'organization_id' => $i+1
                    ]);
                    $candidate->organizations()->save($org);
                }
            }
        });

        //create round 1 judges
        foreach (Role::where('name', 'LIKE', 'judge 1%')->get() as $role) {
            factory(App\User::class, 3)->create()->each(function ($user) use($role) {
                $user->assignRole($role);
            });
        }

        //assign judges
        $scoring = new ScoringService();
        $scoring->assignJudges();

        $scores = Round1Score::get();
        $scale = [0, 1, 2, 3, 4, 5];
        foreach ($scores as $value) {
            $value->update([
                'academics_score'   => $faker->randomElement($scale),
                'reflection_score'  => $faker->randomElement($scale),
                'activities_score'  => $faker->randomElement($scale),
                'services_score'    => $faker->randomElement($scale)
            ]);
        }
    }
}
