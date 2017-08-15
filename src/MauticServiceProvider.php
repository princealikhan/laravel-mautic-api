<?php namespace Vladko\Mautic;

use Illuminate\Contracts\Foundation\Application;
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
    public function register()
    {
        $this->registerFactory($this->app);
        $this->registerManager($this->app);
        $this->registerRoutes($this->app);
    }

    /**
     * Register the factory class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerFactory(Application $app)
    {
        $app->singleton('mautic.factory', function () {
            return new Factories\MauticFactory();
        });

        $app->alias('mautic.factory', 'Vladko\Mautic\Factories\MauticFactory');
    }

    /**
     * Register the manager class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function registerManager(Application $app)
    {
        $app->singleton('mautic', function ($app) {
            $config = $app['config'];
            $factory = $app['mautic.factory'];

            return new Mautic($config, $factory);
        });

        $app->alias('mautic', 'Vladko\Mautic\Mautic');
    }

    /**
     * Get the routes services provided by the provider.
     *
     * @return routes
     */
    protected function registerRoutes(Application $app) {
        $app['router']->group(['namespace' => 'Vladko\Mautic\Http\Controllers', "prefix" => "mautic"], function () {
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
