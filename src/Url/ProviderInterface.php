<?php
namespace Nodes\Assets\Url;

/**
 * Interface ProviderInterface
 *
 * @package Nodes\Assets\Url
 */
interface ProviderInterface
{
    /**
     * Retrieve URL from assets path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  string $path
     * @return string
     */
    public function getUrlFromPath($path);
}
