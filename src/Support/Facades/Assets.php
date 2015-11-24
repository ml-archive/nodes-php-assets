<?php
namespace Nodes\Assets\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Assets Facade
 *
 * @package Nodes\Support\Facades
 */
class Assets extends Facade
{
    /**
     * Get the registered name of the component
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access protected
     * @return string
     */
    protected static function getFacadeAccessor() { return 'nodes.assets'; }
}
