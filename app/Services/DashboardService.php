<?php
namespace App\Services;
use App\Candidate;
use App\Services\AppSettingsService;
use App\ApplicationStates;



class DashboardService
{
    public function getTotalCandidates()
    {
        return Candidate::count();
    }

    public function getTotalNominated()
    {
        return Candidate::where('nominated', true)->count();
    }

    public function getTotalSubmitted()
    {
        return Candidate::submitted()->count();
    }

    public function getCurrentApplicationState()
    {
        $settings = new AppSettingsService();
        return ApplicationStates::find($settings->getCurrentState())->name;
    }
}
