<?php
namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use App\Auth\UserAuthGuard;
use Illuminate\Support\ServiceProvider;

class UserAuthProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {  
        Auth::provider('user', function ($app, array $config) {
            return new UserAuthGuard();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}