<?php

namespace App\Providers;

use App\Modules\CheckIn\CheckInModule;
use App\Modules\Visitor\VisitorModule;
use Illuminate\Support\ServiceProvider;
use App\Modules\CheckIn\CheckInModuleInterface;
use App\Modules\Visitor\VisitorModuleInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VisitorModuleInterface::class, VisitorModule::class);
        $this->app->bind(CheckInModuleInterface::class, CheckInModule::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
