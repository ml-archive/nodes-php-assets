<?php
namespace Nodes\Assets;

use Illuminate\Foundation\AliasLoader;
use Nodes\AbstractServiceProvider as NodesServiceProvider;
use Nodes\Assets\Support\Facade\Assets;

/**
 * Class ServiceProvider
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 * @package Nodes\Assets
 */
class ServiceProvider extends NodesServiceProvider
{
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @return void
     */
    public function register()
    {
        $this->registerManager();
        $this->setupBindings();
        $this->loadHelpers(__DIR__ . DIRECTORY_SEPARATOR . 'Support' . DIRECTORY_SEPARATOR . 'Helpers' . DIRECTORY_SEPARATOR);
        $this->registerFacade();
    }

    /**
     * Setup container binding
     *
     * @author Morten Rugaard <moru@nodes.dk>
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
     * @author Casper Rasmussen <cr@nodes.dk>
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
     * @author Casper Rasmussen <cr@nodes.dk>
     */
    public function registerFacade()
    {
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Assets', Assets::class);
        });
    }
}