<?php

namespace App\Providers;

use App\Models\Facility;
use App\Models\Partner;
use App\Models\Category;
use App\Models\Program;
use App\Models\Setting;
use App\Models\About;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }


public function boot(): void
{
    View::share('destinations', cache()->remember('shared_destinations', 60 * 60, function () {
        try {
            return \App\Models\Category::oldest()->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }));

    View::share('services', cache()->remember('shared_services', 60 * 60, function () {
        try {
            return \App\Models\Program::oldest()->get();
        } catch (\Throwable $e) {
            return collect();
        }
    }));

    View::share('setting', cache()->remember('shared_setting', 60 * 60, function () {
        try {
            return \App\Models\Setting::first();
        } catch (\Throwable $e) {
            return null;
        }
    }));

    View::share('about', cache()->remember('shared_about', 60 * 60, function () {
        try {
            return \App\Models\About::first();
        } catch (\Throwable $e) {
            return null;
        }
    }));
}

}
