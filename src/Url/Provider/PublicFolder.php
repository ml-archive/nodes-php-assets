<?php
namespace Nodes\Assets\Url\Provider;

use Nodes\Assets\Url\AbstractUrlProvider;

class PublicFolder extends AbstractUrlProvider
{
    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param $assetPath
     * @return string
     */
    public function getUrlFromPath($assetPath)
    {
        // Generated URL for asset file
        return ($this->getUrlProtocol() . config('nodes.assetsv2.provider.publicFolder.domain') . '/' . config('nodes.assetsv2.provider.publicFolder.uploads') . '/' . $assetPath);
    }
}