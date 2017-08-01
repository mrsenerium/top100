<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class PaginationServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Paginator::currentPathResolver(function () {
            //get current url and separate into parts
            $baseUrl = $this->app['request']->url();
            $urlParts = parse_url($baseUrl);

            //check .env for proxy settings
            $proxy_url    = env('PROXY_URL');
            $proxy_schema = env('PROXY_SCHEMA');
            if (!empty($proxy_url)) {
                //get default path
                $path = $urlParts['path'];
                //create new url parts from proxy setting
                $urlParts = parse_url($proxy_url);
                //append original path to proxy path
                $urlParts['path'] .= $path;
            }
            if (!empty($proxy_schema)) {
                //set scheme from setting
                $urlParts['scheme'] = strtolower($proxy_schema);
            }

            //manually concatenate parts to create correct URL
            //TODO: reduce hard-coding, look into http_build_url (php7)
            return $urlParts['scheme'].'://'.$urlParts['host'].$urlParts['path'];
        });

        Paginator::currentPageResolver(function ($pageName = 'page') {
            $page = $this->app['request']->input($pageName);

            if (filter_var($page, FILTER_VALIDATE_INT) !== false && (int) $page >= 1) {
                return $page;
            }

            return 1;
        });
    }
}
