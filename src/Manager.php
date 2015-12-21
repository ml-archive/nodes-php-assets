<?php
namespace Nodes\Assets;

use Nodes\Assets\Support\DataUri;
use Nodes\Assets\Upload\Exceptions\AssetsBadRequestException;
use Nodes\Assets\Upload\ProviderInterface as UploadProviderInterface;
use Nodes\Assets\Upload\Settings as UploadSettings;
use Nodes\Assets\Url\ProviderInterface as UrlProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Manager
 *
 * @package Nodes\Assets
 */
class Manager
{
    /**
     * Upload provider
     * 
     * @var \Nodes\Assets\Upload\ProviderInterface
     */
    protected $uploadProvider;

    /**
     * URL provider
     *
     * @var \Nodes\Assets\Url\ProviderInterface
     */
    protected $urlProvider;

    /**
     * Manager constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param \Nodes\Assets\Upload\ProviderInterface $uploadProvider
     * @param \Nodes\Assets\Url\ProviderInterface    $urlProvider
     */
    public function __construct(UploadProviderInterface $uploadProvider, UrlProviderInterface $urlProvider)
    {
        $this->uploadProvider = $uploadProvider;
        $this->urlProvider = $urlProvider;
    }

    /**
     * Save/Upload an uploaded file
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param  string                                              $folder
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     * @return string $path
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromUploadedFile(UploadedFile $file, $folder = null, UploadSettings $settings = null)
    {
        // Generate settings
        if (!$settings) {
            $settings = new UploadSettings;
        }

        // Upload and return path
        return $this->uploadProvider->addFromUpload($file, $folder, $settings);
    }

    /**
     * Save/Upload file from a Data URI
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  string                        $dataUri
     * @param  string                        $folder
     * @param  \Nodes\Assets\Upload\Settings $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromDataUri($dataUri, $folder = null, UploadSettings $settings = null)
    {
        // Make sure we actually have data to work with
        if (empty($dataUri)) {
            return null;
        }

        // Validate data URI
        if (!is_string($dataUri) || !DataUri::isParsable($dataUri)) {
            throw (new AssetsBadRequestException('The passed data uri is not valid data:[<mediatype>][;base64],<data>'))->setStatusCode(400);
        }

        // Generate settings
        if (!$settings) {
            $settings = new UploadSettings;
        }

        // Upload and return path
        return $this->uploadProvider->addFromDataUri($dataUri, $folder, $settings);
    }

    /**
     * Save/Upload file from URL
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  string                        $url
     * @param  string                        $folder
     * @param  \Nodes\Assets\Upload\Settings $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromUrl($url, $folder = null, UploadSettings $settings = null)
    {
        // Make sure we actually have data to work with
        if (empty($url)) {
            return null;
        }

        // Validate URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw (new AssetsBadRequestException('The passed url is not a valid url'))->setStatusCode(400);
        }

        // Generate settings
        if (!$settings) {
            $settings = new UploadSettings;
        }

        // Upload and return path
        return $this->uploadProvider->addFromUrl($url, $folder, $settings);
    }

    /**
     * Save/Upload file with auto-dectection of file type
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  mixed                              $file
     * @param  string|null                        $folder
     * @param  \Nodes\Assets\Upload\Settings|null $settings
     * @return null|string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function add($file, $folder = null, UploadSettings $settings = null)
    {
        // Make sure we actually have data to work with
        if (empty($file)) {
            return null;
        }

        // Determine what kind of save/upload method
        // we should use to process this file
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return $this->addFromUrl($file, $folder, $settings);
        } elseif (is_string($file) && DataUri::isParsable($file)) {
            return $this->addFromDataUri($file, $folder, $settings);
        } else if ($file instanceof UploadedFile) {
            return $this->addFromUploadedFile($file, $folder, $settings);
        } else {
            throw (new AssetsBadRequestException('Uploaded file/string type is not supported'))->setStatusCode(400);
        }
    }

    /**
     * Generate the url from the asset path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  string $path
     * @return string|null
     */
    public function get($path)
    {
        // Make sure we have a file
        if (empty($path)) {
            return null;
        }

        // Generate file URL
        $url = $this->urlProvider->getUrlFromPath($path);

        // Validate file URL
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        return $url;
    }
}
