<?php
use App\CandidateResponse;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

// $factory->define(App\User::class, function (Faker\Generator $faker) {
//     return [
//         'name' => $faker->name,
//         'email' => $faker->email,
//         'password' => bcrypt(str_random(10)),
//         'remember_token' => str_random(10),
//     ];
// });


$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname'  => $faker->lastName,
        'username'  => $faker->unique()->userName.$faker->unique()->randomNumber(4),
        'email'     => $faker->safeEmail,
        'password'  => bcrypt(str_random(24))
    ];
});

$factory->define(App\Candidate::class, function (Faker\Generator $faker) {
    return [
        'gender'        => $faker->randomElement(['M', 'F', 'U']),
        'gpa'           => $faker->randomFloat(2, 3.0, 4.0),
        'class'         => $faker->randomElement([30, 40]),
        'college'       => $faker->randomElement(['ULAS', 'UCOB', 'UCPHS', 'UJCA', 'UCOE', 'UCCOM']),
        'major'         => strtoupper($faker->word),
        'total_hours'   => $faker->numberBetween(80, 120),
        'nominated'     => $faker->boolean(66),
        'disqualified'  => $faker->boolean(3)
    ];
});

$factory->define(App\CandidateResponse::class, function (Faker\Generator $faker) {
    $reflection = join('</p><p>', $faker->paragraphs(3));
    return [
        'additional_majors' => $faker->randomDigitNotNull % 2 == 0 ? $faker->words(2, true) : '',
        'academic_honors'   => $faker->words(4, true),
        'reflection'        => '<p>'.$reflection.'</p>',
        'submitted'         => $faker->boolean(75)
    ];
});

$factory->define(App\CandidateOrganization::class, function (Faker\Generator $faker) {
    return [
        'name'                  => $faker->company,
        'description'           => $faker->sentences(3, true),
        'position_held'         => $faker->jobTitle,
        'involvement_length'    => $faker->numberBetween(1, 24),
        'involvement_duration'  => $faker->randomElement(['hours', 'days', 'months', 'years']),
        'organization_type'     => $faker->randomElement(['activity', 'service'])
    ];
});
