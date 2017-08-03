<?php

namespace App\Providers;

use App\Facades\AppSettings;
use Illuminate\Support\ServiceProvider;
use App;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(AppSettings::getTestMode()) {
            config([
                'mail.driver' => 'log'
            ]);
        }

        Blade::directive('striptags', function ($expression) {
            return "<?php echo strip_tags(\$__env->yieldContent{$expression}); ?>";
        });

        $proxy_url    = env('PROXY_URL');
        $proxy_schema = env('PROXY_SCHEMA');

        if (!empty($proxy_url)) {
           \URL::forceRootUrl($proxy_url);
        }

        if (!empty($proxy_schema)) {
           \URL::forceSchema($proxy_schema);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //register settings service
        $this->app->singleton('AppSettingsService', function ($app) {
            return new \App\Services\AppSettingsService();
        });

        $this->app->singleton('RoleList', function ($app) {
            return new \App\Services\RoleListService();
        });

        $this->app->singleton('Scoring', function ($app) {
            return new \App\Services\ScoringService();
        });
    }
}
