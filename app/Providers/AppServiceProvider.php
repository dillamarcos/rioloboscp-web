<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

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
        Auth::viaRemember(function ($user) {
            Cookie::queue(Cookie::make(
                Auth::getRecallerName(),
                request()->cookie(Auth::getRecallerName()),
                43200 // 30 días en minutos
            ));
        });
    }
}
