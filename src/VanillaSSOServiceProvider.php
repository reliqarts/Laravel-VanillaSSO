<?php

namespace ReliQArts\VanillaSSO;

use Illuminate\Support\ServiceProvider;

/**
 *  VanillaSSOServiceProvider.
 */
class VanillaSSOServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Assets location.
     */
    protected $assetsDir = __DIR__.'/..';

    /**
     * Publish assets.
     *
     * @return void
     */
    protected function publishAssets()
    {
        $this->publishes([
            "$this->assetsDir/config/vanillasso.php" => config_path('vanillasso.php'),
        ], 'config');
    }

    /**
     * Register Configuraion.
     */
    protected function registerConfig()
    {
        // merge config
        $this->mergeConfigFrom("$this->assetsDir/config/vanillasso.php", 'vanillasso');
    }

    /**
     * Register routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        // get the routes
        require_once "$this->assetsDir/routes/web.php";
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // register routes
        if (! $this->app->routesAreCached()) {
            $this->registerRoutes();
        }

        // publish assets
        $this->publishAssets();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }
}
