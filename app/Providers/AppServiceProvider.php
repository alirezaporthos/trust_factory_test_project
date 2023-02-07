<?php

namespace App\Providers;

use App\Models\Invite;
use App\Observers\InviteObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Invite::observe(InviteObserver::class);
    }
}
