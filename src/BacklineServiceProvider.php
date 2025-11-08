<?php

namespace S4mpp\Backline;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\AboutCommand;

class BacklineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'backline');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        if ($this->app->runningInConsole()) {
            AboutCommand::add('Backline', fn () => [
                'Guard' => Backline::getGuardName(),
            ]);

            $this->publishes([
                __DIR__.'/../assets/dist' => public_path('vendor/backline'),
            ], 'backline-assets');
        }
    }
}
