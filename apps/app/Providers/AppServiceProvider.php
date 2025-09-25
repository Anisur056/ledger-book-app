<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    protected $policies = [
        Business::class => BusinessPolicy::class,
        LedgerBook::class => LedgerBookPolicy::class,
        VoucherTransection::class => VoucherTransectionPolicy::class,
    ];

    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
