<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AffiliateService;
use App\Models\Referral;
use App\Models\User;
use App\Models\AffiliateSetting;
use App\Observers\ReferralObserver;
use App\Observers\UserObserver;

class AffiliateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AffiliateService::class, function ($app) {
            return new AffiliateService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register observers
        Referral::observe(ReferralObserver::class);
        User::observe(UserObserver::class);
        
        // Share affiliate settings with views
        view()->composer('*', function ($view) {
            $view->with('affiliateProgramActive', AffiliateSetting::get('affiliate_program_active', true));
            $view->with('commissionRate', AffiliateSetting::get('commission_rate', 300));
        });
        
        // Add affiliate info to views based on user
        view()->composer(['layouts.app', 'dashboard'], function ($view) {
            if (auth()->check()) {
                $user = auth()->user();
                $view->with('canAffiliate', $user->canAffiliate());
                
                if ($user->canAffiliate() && $user->affiliateDetails) {
                    $view->with('affiliateDetails', $user->affiliateDetails);
                    $view->with('referralLink', url('/?ref=' . $user->affiliateDetails->affiliate_code));
                }
            }
        });
    }
}