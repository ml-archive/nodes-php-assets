<?php

namespace Nodes\Assets\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Assets Facade.
 */
class Assets extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'nodes.assets';
    }
}
