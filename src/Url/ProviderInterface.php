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
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param $path
     * @return mixed
     */
    public function getUrlFromPath($path);
}
