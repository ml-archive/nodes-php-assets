<?php
namespace Nodes\Assets\Url\Provider;

use Nodes\Assets\Url\AbstractUrlProvider;

class NodesCdn extends AbstractUrlProvider
{
    public function __construct(array $nodesConfig)
    {
        $this->nodesConfig = $nodesConfig;
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param $assetPath
     * @return string
     */
    public function getUrlFromPath($assetPath)
    {
        // Parse file path
        $filePath = pathinfo($assetPath);

        // Determine internal file type ("images" or "data")
        $fileType = array_key_exists(strtolower($filePath['extension']), $this->nodesConfig['imageExtensionMimeTypes']) ? 'images' : 'data';

        // Extract folder name from asset path
        $folder = substr($filePath['dirname'], 0, strpos($filePath['dirname'], '/')) ?: $filePath['dirname'];

        // If file type is an image, we'll have to support
        if ($fileType == 'images') {
            $folderPath = 'image' . DIRECTORY_SEPARATOR . env('APP_NAME') . DIRECTORY_SEPARATOR;
        } else {
            // Download and data folder path
            $folderPath = $fileType . DIRECTORY_SEPARATOR . env('APP_NAME') . DIRECTORY_SEPARATOR;
        }

        // Generated URL for asset file
        return $this->getUrlProtocol() . $this->nodesConfig['cloudfront_url'] . $folderPath . $folder . '/' . $filePath['basename'];
    }
}