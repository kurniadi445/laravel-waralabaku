<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer([
            'tampilan.laporan.*',
            'tampilan.master.*',
            'tampilan.dasbor'
        ], function (\Illuminate\View\View $view) {
            $level = Auth::user()->{'level'};

            $view->with('level', $level);
        });
    }
}
