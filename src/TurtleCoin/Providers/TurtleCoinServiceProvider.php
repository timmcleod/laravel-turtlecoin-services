<?php

namespace TurtleCoin\Providers;

use Illuminate\Support\ServiceProvider;
use TurtleCoin\Console\Commands\StartWalletService;
use TurtleCoin\TurtleCoinServices;

class TurtleCoinServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                StartWalletService::class
            ]);
        }

        // Publishes a config file to the project after running:
        // php artisan vendor:publish
        $this->publishes([
            __DIR__ . '/../../../config/turtlecoin.php' => config_path('turtlecoin.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('turtlecoin', function ($app)
        {
            return new TurtleCoinServices(
                $app['config']['turtlecoin.wallet_service_host'],
                $app['config']['turtlecoin.wallet_service_port'],
                $app['config']['turtlecoin.wallet_service_rpc_password'],
                $app['config']['turtlecoin.daemon_host'],
                $app['config']['turtlecoin.daemon_port']
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['turtlecoin'];
    }
}