<?php

namespace Nodes\Assets\Url;

/**
 * Interface ProviderInterface.
 */
interface ProviderInterface
{
    /**
     * Retrieve URL from assets path.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  string $path
     * @return string
     */
    public function getUrlFromPath($path);
}
