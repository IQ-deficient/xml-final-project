<?php

namespace App\Providers;

use http\Env\Request;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
//        Inertia::share('flash', function (Request $request) {
//            return [
//                'message' => $request->session()->get('message')
//            ];
//        });
    }
}
