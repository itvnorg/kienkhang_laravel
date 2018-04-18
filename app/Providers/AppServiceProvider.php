<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            base_path().'/vendor/kartik-v/bootstrap-fileinput/css/fileinput.min.css' => public_path('vendor/bootstrap-fileinput/css/fileinput.min.css'),
            base_path().'/vendor/kartik-v/bootstrap-fileinput/js/fileinput.min.js' => public_path('vendor/bootstrap-fileinput/js/fileinput.min.js'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register(\MaddHatter\ViewGenerator\ServiceProvider::class);
        }
    }
}
