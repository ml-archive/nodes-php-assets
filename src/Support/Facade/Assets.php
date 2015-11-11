<?php
namespace Nodes\Assets\Support\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * Class Nodes Asset Facade
 *
 * @package Nodes\Support\Facade
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
