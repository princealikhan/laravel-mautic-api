<?php

namespace Princealikhan\Mautic;

use Illuminate\Support\ServiceProvider;

class MauticServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Publish Configuration File to base Path.
        $this->publishes([
            __DIR__.'/config/mautic.php' => base_path('config/mautic.php'),
            __DIR__ . '/migrations' => $this->app->databasePath() . '/migrations'
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->registerFactory();
        $this->registerManager();
        $this->registerRoutes();
    }

    /**
     * Register the factory class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerFactory()
    {
        $this -> app->singleton('mautic.factory', function () {
            return new Factories\MauticFactory();
        });

        $this -> app->alias('mautic.factory', 'Princealikhan\Mautic\Factories\MauticFactory');
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerManager()
    {
        $this -> app->singleton('mautic', function ($app) {
            $config = $app['config'];
            $factory = $app['mautic.factory'];

            return new Mautic($config, $factory);
        });

        $this -> app->alias('mautic', 'Princealikhan\Mautic\Mautic');
    }

    /**
     * Get the routes services provided by the provider.
     *
     * @return routes
     */
    protected function registerRoutes() {
        $this -> app ->group(['namespace' => 'Princealikhan\Mautic\Http\Controllers', "prefix" => "mautic"], function () {
            require __DIR__.'/Http/routes.php';
        });
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'mautic',
            'mautic.factory',
        ];
    }
}
