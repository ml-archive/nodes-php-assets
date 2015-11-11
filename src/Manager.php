<?php
namespace Nodes\Assets;

use Nodes\Assets\Support\Helpers\DataUri;
use Nodes\Assets\Upload\Exception\AssetBadRequestException;
use Nodes\Assets\Upload\ProviderInterface as UploadProviderInterface;
use Nodes\Assets\Upload\Settings as UploadSettings;

use Nodes\Assets\Url\ProviderInterface as UrlProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Manager
 * @author  Casper Rasmussen <cr@nodes.dk>
 *
 * @package Nodes\Assets
 */
class Manager
{
    protected $uploadProvider;
    protected $urlProvider;

    public function __construct(UploadProviderInterface $uploadProvider, UrlProviderInterface $urlProvider)
    {
        $this->uploadProvider = $uploadProvider;
        $this->urlProvider = $urlProvider;
    }

    public function addFromUploadedFile(UploadedFile $file, $folder = null, UploadSettings $settings = null) {
        // Generate settings
        if(!$settings) {
            $settings = new UploadSettings();
        }

        // Upload and return path
        return $this->uploadProvider->addFromUpload($file, $folder, $settings);
    }



    public function addFromDataUri($dataUri, $folder = null, UploadSettings $settings = null) {
        if (empty($dataUri)) {
            return null;
        }

        if(!is_string($dataUri) || !DataUri::isParsable($dataUri)) {
            throw new AssetBadRequestException('The passed data uri is not valid data:[<mediatype>][;base64],<data>');
        }

        // Generate settings
        if(!$settings) {
            $settings = new UploadSettings();
        }

        // Upload and return path
        return $this->uploadProvider->addFromDataUri($dataUri, $folder, $settings);
    }

    public function addFromUrl($url, $folder = null, UploadSettings $settings = null) {

        if (empty($url)) {
            return null;
        }

        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new AssetBadRequestException('The passed url is not a valid url');
        }

        // Generate settings
        if(!$settings) {
            $settings = new UploadSettings();
        }

        // Upload and return path
        return $this->uploadProvider->addFromUrl($url, $folder, $settings);
    }


    public function add($file, $folder = null, UploadSettings $settings = null)
    {
        //To avoid empty checks all over
        if (empty($file)) {
            return null;
        }

        if (filter_var($file, FILTER_VALIDATE_URL)) {
            return $this->addFromUrl($file, $folder, $settings);
        } elseif (is_string($file) && DataUri::isParsable($file)) {
            return $this->addFromDataUri($file, $folder, $settings);
        } else if ($file instanceof UploadedFile) {
            return $this->addFromUploadedFile($file, $folder, $settings);
        } else {
            throw new AssetBadRequestException('Uploaded file/string type is not supported');
        }
    }


    public function get($path)
    {
        // Make sure we have a file
        if (empty($path)) {
            return null;
        }

        // Generate file URL
        $url = $this->urlProvider->getUrlFromPath($path);

        // Validate file URL
        if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        return $url;
    }
}
