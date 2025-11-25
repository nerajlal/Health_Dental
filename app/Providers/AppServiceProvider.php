<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Bag;

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
        // Schema::defaultStringLength(191);
        
        View::composer('*', function ($view) {
            if (auth()->check() && auth()->user()->role === 'clinic') {
                $bagCount = Bag::where('clinic_id', auth()->id())->count();
                $view->with('bagCount', $bagCount);
            } else {
                $view->with('bagCount', 0);
            }
        });
    }
}
