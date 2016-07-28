<?php

namespace Nodes\Assets\Url;

/**
 * Class AbstractUrlProvider.
 *
 * @abstract
 */
abstract class AbstractUrlProvider implements ProviderInterface
{
    /**
     * Get URL protocol by server settings.
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @return string
     */
    protected function getUrlProtocol()
    {
        return (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
    }
}
