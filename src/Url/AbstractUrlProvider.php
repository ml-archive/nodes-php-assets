<?php
namespace Nodes\Assets\Url;

/**
 * Class AbstractUrlProvider
 *
 * @abstract
 * @package Nodes\Assets\Url
 */
abstract class AbstractUrlProvider implements ProviderInterface
{
    /**
     * Get URL protocol by server settings
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @access protected
     * @return string
     */
    protected function getUrlProtocol()
    {
        return ( ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    }
}
