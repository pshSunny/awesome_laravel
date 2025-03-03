<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class PaginateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Paginator::defaultView('vendor/pagination/bootstrap-5');
        Paginator::defaultSimpleView('vendor/pagination/simple-bootstrap-5');
    }
}
