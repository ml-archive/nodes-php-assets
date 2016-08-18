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

        $filePath = pathinfo($path);

        $fileType = array_key_exists(strtolower($filePath['extension']), config('nodes.assets.providers.publicFolder.imageExtensionMimeTypes')) ? 'images' : 'data';

        // If the asset is type 'data', show the raw file. If it's 'image' we want to use the CDN
        if ($fileType == 'data') {
            return  $this->getUrlProtocol().config('nodes.assets.providers.publicFolder.domain').'/'.config('nodes.assets.providers.publicFolder.subFolder').'/'.$path;
        } else {
            $fileParts = explode('/', $path);
            
            return route('nodes.assets.public_folder.cdn', $fileParts);
        }
    }
}
