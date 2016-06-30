<?php
namespace Nodes\Assets\Url\Providers;

use Nodes\Assets\Url\AbstractUrlProvider;
use Nodes\Exceptions\Exception;

/**
 * Class NodesCdn
 *
 * @package Nodes\Assets\Url\Providers
 */
class NodesCdn extends AbstractUrlProvider
{
    /**
     * Config array
     *
     * @var array
     */
    protected $nodesConfig;

    /**
     * NodesCdn constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @param array $nodesConfig
     * @throws Exception
     */
    public function __construct(array $nodesConfig)
    {
        $this->nodesConfig = $nodesConfig;

        // Check cloudfrontUrl
        if (empty($this->nodesConfig['cloudfrontUrl'])) {
            throw new Exception('cloudfrontUrl is missing in config', 500);
        }

        // Check cloudfrontUrl has trailing /
        if (!$this->endswith($this->nodesConfig['cloudfrontUrl'], '/')) {
            throw new Exception('cloudfrontUrl is missing trailing /', 500);
        }

        // Check cloudfrontUrlData
        if (empty($this->nodesConfig['cloudfrontUrlData'])) {
            throw new Exception('cloudfrontUrlData is missing in config', 500);
        }

        // Check cloudfrontUrlData has trailing /
        if (!$this->endswith($this->nodesConfig['cloudfrontUrlData'], '/')) {
            throw new Exception('cloudfrontUrlData is missing trailing /', 500);
        }

        // Check that imageExtensionMimeTypes is correct
        if (!isset($this->nodesConfig['imageExtensionMimeTypes']) ||
            !is_array($this->nodesConfig['imageExtensionMimeTypes'])
        ) {
            throw new Exception('imageExtensionMimeTypes is missing in config or not an array', 500);
        }
    }

    /**
     * Retrieve URL from assets path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     * @param  string $assetPath
     * @throws Exception
     * @return string
     */
    public function getUrlFromPath($assetPath)
    {
        // Parse file path
        $filePath = pathinfo($assetPath);

        if (empty($filePath['extension'])) {
            throw new Exception(sprintf('Missing extension of file [%s]', $assetPath), 500);
        }

        // Determine internal file type ("images" or "data")
        $fileType = array_key_exists(strtolower($filePath['extension']), $this->nodesConfig['imageExtensionMimeTypes']) ? 'images' : 'data';

        // Extract folder name from asset path
        $folder = substr($filePath['dirname'], 0, strpos($filePath['dirname'], '/')) ?: $filePath['dirname'];

        // If file type is an image, we'll have to support
        if ($fileType == 'images') {
            // Generated URL for asset file
            return $this->getUrlProtocol() . $this->nodesConfig['cloudfrontUrl'] . 'image' . DIRECTORY_SEPARATOR .
                   env('APP_NAME') . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR .
                   $filePath['basename'];
        } else {
            // Download and data folder path
            return $this->getUrlProtocol() . $this->nodesConfig['cloudfrontUrlData'] . env('APP_NAME') .
                   DIRECTORY_SEPARATOR . $fileType . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR .
                   $filePath['basename'];
        }
    }

    /**
     * endswith
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access private
     * @param $string
     * @param $test
     * @return bool
     */
    private function endswith($string, $test)
    {
        $strlen = strlen($string);
        $testlen = strlen($test);
        if ($testlen > $strlen) {
            return false;
        }

        return substr_compare($string, $test, $strlen - $testlen, $testlen) === 0;
    }
}