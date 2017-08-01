<?php

namespace App\Extensions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use AppSettings;

class ButlerAuthProvider extends ServiceProvider {

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Candidate::class => \App\Policies\CandidatePolicy::class
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('apply', function ($user) {
            return !is_null($user->candidate) && $user->can('submit-application', $user->candidate);
        });

        $gate->define('nominate', function ($user) {
            return AppSettings::getCurrentState() == \App\ApplicationStates::Nominations;
        });

        $gate->define('create-guest-list', function ($user) {
            return !is_null($user->candidate) && $user->can('participate-round2', $user->candidate);
        });

        $gate->define('request-recommendations', function ($user) {
            return !is_null($user->candidate) && $user->can('participate-round2', $user->candidate);
        });

        $gate->define('round1-judging', function ($user) {
            return $user->can('judge-round1') && AppSettings::getCurrentState() == \App\ApplicationStates::Round1Judging;
        });

        $gate->define('round2-judging', function ($user) {
            return $user->can('judge-round2') && AppSettings::getCurrentState() == \App\ApplicationStates::Round2Judging;
        });

        $gate->define('recommend', function ($user) {
            return AppSettings::getCurrentState() == \App\ApplicationStates::Round2Open;
        });

        $gate->define('view-own-app', function ($user) {
            return $user->candidate && $user->candidate->application && (!$user->can('apply') || $user->candidate->application->submitted);
        });

        Auth::provider('butler', function($app, array $config) {
          return new ButlerUserProvider($app['hash'], $config['model']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
