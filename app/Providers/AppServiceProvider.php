<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\UserType;

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
        //
        $type=UserType::where('id','!=',1)->get();
        view()->share('type', $type);
    }
}
