<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        \App\Employee::observe(\App\Observers\EmployeeObserver::class);
      \App\EmployeeWage::observe(\App\Observers\EmployeeWageObserver::class);
        \App\Job::observe(\App\Observers\JobObserver::class);
        \App\Workhour::observe(\App\Observers\WorkhourObserver::class);
        \App\Order::observe(\App\Observers\OrderObserver::class);
    }
}
