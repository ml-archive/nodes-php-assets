<?php

namespace Nodes\Assets\Url\Providers;

use Nodes\Assets\Url\AbstractUrlProvider;

/**
 * Class PublicFolder.
 */
class PublicFolder extends AbstractUrlProvider
{
    /**
     * Retrieve URL from assets path.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  string $assetPath
     *
     * @return string
     */
    public function getUrlFromPath($assetPath)
    {
        // Ensure platform independency
        $path = str_replace('\\', '/', $assetPath);

        // Generated URL for asset file
        return  $this->getUrlProtocol().config('nodes.assets.providers.publicFolder.domain').'/'.config('nodes.assets.providers.publicFolder.subFolder').'/'.$path;
    }
}
