<?php
namespace Nodes\Assets\Url\Providers;

use Nodes\Assets\Url\AbstractUrlProvider;

/**
 * Class PublicFolder
 *
 * @package Nodes\Assets\Url\Providers
 */
class PublicFolder extends AbstractUrlProvider
{
    /**
     * Retrieve URL from assets path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  string $assetPath
     * @return string
     */
    public function getUrlFromPath($assetPath)
    {
        // Generated URL for asset file
        return ($this->getUrlProtocol() . config('nodes.assetsv2.provider.publicFolder.domain') . '/' . config('nodes.assetsv2.provider.publicFolder.uploads') . '/' . $assetPath);
    }
}