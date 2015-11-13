<?php
namespace Nodes\Assets;

use Illuminate\Foundation\AliasLoader;
use Nodes\AbstractServiceProvider as NodesServiceProvider;
use Nodes\Assets\Support\Facade\Assets;

/**
 * Class ServiceProvider
 *
 * @package Nodes\Assets
 */
class ServiceProvider extends NodesServiceProvider
{
    /**
     * Register the service provider.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @return void
     */
    public function register()
    {
        parent::register();
        $this->registerManager();
        $this->setupBindings();
        $this->registerFacade();
    }

    /**
     * Setup container binding
     *
     * @author Casper Rasmussen <moru@nodes.dk>
     *
     * @access protected
     * @return void
     */
    protected function setupBindings()
    {
        $this->app->bind('Nodes\Assets\Manager', function ($app) {
            return $app['nodes.assets'];
        });
    }

    /**
     * Register assets manager
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @return void
     */
    public function registerManager()
    {
        $this->app->bindShared('nodes.assets', function ($app) {

            $uploadProvider = call_user_func(config('nodes.assetsv2.general.upload.provider'), $app);
            $urlProvider = call_user_func(config('nodes.assetsv2.general.url.provider'), $app);

            return new Manager($uploadProvider, $urlProvider);
        });
    }

    /**
     * Register assets facade
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @return void
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Assets', Assets::class);
        });
    }
}