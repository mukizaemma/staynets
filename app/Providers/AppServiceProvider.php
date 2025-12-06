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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('destinations', Category::oldest()->get());
        View::share('services', Program::oldest()->get());
        View::share('setting', Setting::first());
        View::share('about', About::first());
    }
}
