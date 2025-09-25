<?php

namespace App\Providers;

use App\Models\Business;
use App\Models\LedgerBook;
use App\Models\VoucherTransection;
use App\Models\AccountsHead;
use App\Policies\BusinessPolicy;
use App\Policies\LedgerBookPolicy;
use App\Policies\VoucherTransectionPolicy;
use App\Policies\AccountsHeadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Business::class => BusinessPolicy::class,
        LedgerBook::class => LedgerBookPolicy::class,
        VoucherTransection::class => VoucherTransectionPolicy::class,
        AccountsHead::class => AccountsHeadPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}