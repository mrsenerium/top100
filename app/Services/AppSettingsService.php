<?php
namespace App\Services;

use Settings;

class AppSettingsService
{
    /* application settings */
    public function getTestMode()
    {
        return !app()->environment('prod', 'production', 'live');
    }

    // /* application settings */
    public function getSeparateGenders()
    {
        return Settings::get('application.separate-genders', true);
    }

    public function setSeparateGenders($value)
    {
        Settings::set('application.separate-genders', $value);
    }

    public function getCurrentState()
    {
        return Settings::get('application.current-state', 1);
    }

    public function setCurrentState($value)
    {
        Settings::set('application.current-state', $value);
    }

    public function getReflectionQuestion()
    {
        return Settings::get('application.reflection-question', 'Reflection question has not been set');
    }

    public function setReflectionQuestion($value)
    {
        Settings::set('application.reflection-question', $value);
    }

    public function getOrganizationMax()
    {
        return Settings::get('application.organization-max', 7);
    }

    public function setOrganizationMax($value)
    {
        Settings::set('application.organization-max', $value);
    }

    public function save()
    {
        Settings::save();
    }
}
