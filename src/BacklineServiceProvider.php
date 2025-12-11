<?php

namespace S4mpp\Backline;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use S4mpp\Backline\Composers\MenuComposer;
use Illuminate\Foundation\Console\AboutCommand;

class BacklineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'backline');

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        View::composer([
            'backline::layout.body',
        ], MenuComposer::class);

        if ($this->app->runningInConsole()) {
            AboutCommand::add('Backline', fn () => [
                'Guard' => Backline::getGuardName(),
            ]);

            $this->publishes([
                __DIR__.'/../assets/dist' => public_path('vendor/backline'),
            ], 'backline-assets');

            $this->publishes([
                __DIR__.'/../stubs/config.stub' => config_path('backline.php'),
            ], 'backline-config');
        }
    }
}
