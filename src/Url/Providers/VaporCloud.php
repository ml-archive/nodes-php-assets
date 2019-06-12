<?php

namespace Nodes\Assets\Url\Providers;

use Nodes\Assets\Url\AbstractUrlProvider;
use Nodes\Exceptions\Exception;

/**
 * Class VaporCloud
 *
 * @package Nodes\Assets\Url\Providers
 */
class VaporCloud extends AbstractUrlProvider
{
    /**
     * Config array.
     *
     * @var array
     */
    protected $config;

    /**
     * VaporCloud constructor
     *
     * @param array $config
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        // Check cloudfrontUrl
        if (empty($this->config['cdnUrl'])) {
            throw new Exception('cdnUrl is missing in config', 500);
        }

        // Check cloudfrontUrl has trailing /
        if (!$this->endswith($this->config['cdnUrl'], '/')) {
            throw new Exception('cdnUrl is missing trailing /', 500);
        }

        // Check cloudfrontUrlData
        if (empty($this->config['cdnRawUrl'])) {
            throw new Exception('cloudfrontUrlData is missing in config', 500);
        }

        // Check cloudfrontUrlData has trailing /
        if (!$this->endswith($this->config['cdnRawUrl'], '/')) {
            throw new Exception('cdnRawUrl is missing trailing /', 500);
        }

        // Check that imageExtensionMimeTypes is correct
        if (!isset($this->config['imageExtensionMimeTypes']) ||
            !is_array($this->config['imageExtensionMimeTypes'])) {
            throw new Exception('imageExtensionMimeTypes is missing in config or not an array', 500);
        }
    }

    /**
     * Retrieve URL from assets path.
     *
     * @param string $assetPath
     * @return string
     * @throws Exception
     * @author Casper Rasmussen <cr@nodes.dk>
     */
    public function getUrlFromPath($assetPath)
    {
        // Parse file path
        $filePath = pathinfo($assetPath);

        if (empty($filePath['extension'])) {
            throw new Exception(sprintf('Missing extension of file [%s]', $assetPath), 500);
        }

        // Determine internal file type ("images" or "data")
        $fileType = array_key_exists(strtolower($filePath['extension']),
            $this->config['imageExtensionMimeTypes']) ? 'images' : 'data';

        // Extract folder name from asset path
        $folder = substr($filePath['dirname'], 0, strpos($filePath['dirname'], '/')) ?: $filePath['dirname'];

        $schema = $this->getUrlProtocol();

        $path = call_user_func($this->config['generateCdnUrl'], $this->config, $filePath, $fileType, $folder, $schema);

        return $path;
    }

    /**
     * endswith.
     *
     * @param $string
     * @param $test
     * @return bool
     * @author Casper Rasmussen <cr@nodes.dk>
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
