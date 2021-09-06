<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // \App\Member::observe(\App\Observers\SchoolMemberObserver::class);

        Schema::defaultStringLength(191);
        $supportedLanguageKeys = LaravelLocalization::getSupportedLanguagesKeys();

        if(in_array(Request::segment(1), $supportedLanguageKeys))
        {
            $home_menu = '';
            $home_menu = Request::segment(2);
            view()->share('home_menu',$home_menu);

            $menu = '';
            $menu = Request::segment(3);
            view()->share('menu',$menu);
        }
        else {
            $home_menu = '';
            $home_menu = Request::segment(1);
            view()->share('home_menu',$home_menu);

            $menu = '';
            $menu = Request::segment(2);
            view()->share('menu',$menu);
        }
    }
}
