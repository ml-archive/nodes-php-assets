<?php

namespace Nodes\Assets;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @author Morten Rugaard <moru@nodes.dk>
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->publishGroups();
    }

    /**
     * Register the service provider.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return void
     */
    public function register()
    {
        $this->registerManager();
        $this->setupBindings();
    }

    /**
     * Register publish groups.
     *
     * @author Morten Rugaard <moru@nodes.dk>
     * @return void
     */
    protected function publishGroups()
    {
        // Config files
        $this->publishes([
            __DIR__.'/../config/providers/nodes.php'        => config_path('nodes/assets/providers/nodes.php'),
            __DIR__.'/../config/providers/publicFolder.php' => config_path('nodes/assets/providers/publicFolder.php'),
            __DIR__.'/../config/general.php'                => config_path('nodes/assets/general.php'),
        ], 'config');

        // Route files
        $this->publishes([
            __DIR__ . '/../routes' => base_path('project/Routes/Frontend'),
        ], 'routes');
    }

    /**
     * Setup container binding.
     *
     * @author Casper Rasmussen <moru@nodes.dk>
     * @return void
     */
    protected function setupBindings()
    {
        $this->app->bind('Nodes\Assets\Manager', function ($app) {
            return $app['nodes.assets'];
        });
    }

    /**
     * Register assets manager.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return void
     */
    public function registerManager()
    {
        $this->app->singleton('nodes.assets', function ($app) {
            $uploadProvider = call_user_func(config('nodes.assets.general.upload.provider'), $app);
            $urlProvider = call_user_func(config('nodes.assets.general.url.provider'), $app);

            return new Manager($uploadProvider, $urlProvider);
        });
    }
}
