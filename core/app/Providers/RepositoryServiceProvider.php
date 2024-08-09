<?php

namespace App\Providers;

use App\Http\Contracts\ProjectServiceContract;
use App\Http\Services\ProjectService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProjectServiceContract::class, ProjectService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
