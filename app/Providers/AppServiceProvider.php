<?php

namespace App\Providers;

use App\Jobs\CreateThumbnailsJob;
use App\Jobs\DeleteThumbnailsJob;
use App\Services\Thumbnail\CreateThumbnailService;
use App\Services\Thumbnail\DeleteThumbnailService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $this->app->bindMethod([CreateThumbnailsJob::class, 'handle'], function($job, $app) {
            return $job->handle($app->make(CreateThumbnailService::class));
        });

        $this->app->bindMethod([DeleteThumbnailsJob::class, 'handle'], function($job, $app) {
            return $job->handle($app->make(DeleteThumbnailService::class));
        });
    }
}
