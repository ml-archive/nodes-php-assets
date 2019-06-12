<?php

namespace Nodes\Assets\Url\Providers;

use Nodes\Assets\Url\AbstractUrlProvider;
use Nodes\Exceptions\Exception;

/**
 * Class ImgIX
 *
 * @package Nodes\Assets\Url\Providers
 */
class ImgIX extends AbstractUrlProvider
{
    /** @var string */
    protected $url;

    /**
     * NodesCdn constructor.
     *
     * @param array $nodesConfig
     * @throws Exception
     * @author Casper Rasmussen <cr@nodes.dk>
     */
    public function __construct(array $imgIxConfig)
    {
        // Check url
        if (empty($imgIxConfig['url'])) {
            throw new Exception('url is missing in config', 500);
        }

        $this->url = $imgIxConfig['url'];

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
        return $this->getUrlProtocol() . $this->url . DIRECTORY_SEPARATOR . $assetPath;
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
