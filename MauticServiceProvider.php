<?php namespace Princealikhan\Mautic;

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
            __DIR__.'/config/config.php' => base_path('config/mautic.php'),
        ]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app->bind('mautic', function () {
    			return new Mautic;
			});
	}

}
