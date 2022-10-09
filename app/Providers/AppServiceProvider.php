<?php

namespace App\Providers;

use App\Contracts\Repositories\SurveyRepositoryInterface;
use App\Contracts\Services\ResultServiceInterface;
use App\Contracts\Services\SurveyServiceInterface;
use App\Models\Survey;
use App\Repositories\SurveyRepository;
use App\Services\ResultService;
use App\Services\SurveyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SurveyServiceInterface::class, function () {
            return new SurveyService($this->app->make(Survey::class));
        });

        $this->app->bind(ResultServiceInterface::class, function () {
            return new ResultService($this->app->make(SurveyServiceInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
