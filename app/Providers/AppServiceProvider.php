<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\Waitlist;

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
        Gate::define('viewWaitlistStats', function ($user) {
            return $user->isAdmin();
        });
        
        // Share referral code from URL with all views
        View::composer('*', function ($view) {
            $view->with('referralCode', request()->query('ref'));
        });
        
        // Share app version with all views
        View::composer('*', function ($view) {
            $view->with('appVersion', 'Pre-launch v0.1');
        });
    
    }
}
