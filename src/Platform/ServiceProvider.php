<?php


namespace iBrand\Common\Platform;


class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/platform.php' => config_path('ibrand/platform.php'),
            ]);
        }
    }

    public function register()
    {
        $this->app->singleton('ibrand.platform', function ($app) {
            return new Application(config('ibrand.platform.url'), config('ibrand.platform.client_id'), config('ibrand.platform.client_secret'));
        });
    }
}