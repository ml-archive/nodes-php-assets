<?php

namespace Nodes\Assets\Upload\Providers;

use Nodes\Assets\Upload\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class VaporCloud
 *
 * @package Nodes\Assets\Upload\Providers
 */
class VaporCloud extends AmazonS3
{
    /** @var string */
    protected $appName;

    /**
     * VaporCloud constructor
     *
     * @param array $s3Config
     * @param array $vaporCloudConfig
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     */
    public function __construct(array $s3Config, array $vaporCloudConfig)
    {
        parent::__construct($vaporCloudConfig, $s3Config);

        $this->appName = $vaporCloudConfig['appName'];
    }

    /**
     * Upload file to S3.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Nodes\Assets\Upload\Settings                       $settings
     * @return string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     * @author Casper Rasmussen <cr@nodes.dk>
     */
    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        // Fallback folder is none is set
        if (!$settings->hasFolder()) {
            $settings->setFolder('default');
        }

        // Retrieve file path
        $returnPath = $settings->getFilePath();

        // Set folder
        $settings->setFolder($this->getPath($uploadedFile, $settings));

        // Upload file to S3
        parent::store($uploadedFile, $settings);

        return $returnPath;
    }

    /**
     * Retrieve path.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Nodes\Assets\Upload\Settings                       $settings
     * @return string
     * @author Casper Rasmussen <cr@nodes.dk>
     */
    private function getPath(UploadedFile $uploadedFile, Settings $settings)
    {
        return $this->appName . DIRECTORY_SEPARATOR . $this->getSubFolder($uploadedFile) . DIRECTORY_SEPARATOR .
               $settings->getFolder();
    }

    /**
     * Retrieve sub folder.
     *
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @return string
     * @author Casper Rasmussen <cr@nodes.dk>
     */
    private function getSubFolder(UploadedFile $uploadedFile)
    {
        // Find mime type
        $mimeType = $uploadedFile->getMimeType();

        // Clean mime-type for charset
        // and other useless stuff
        if (strpos($mimeType, ';')) {
            $mimeType = explode(';', $mimeType);

            return strtolower($mimeType[0]);
        }

        // Force mime-type to lowercase
        $mimeType = strtolower($mimeType);

        // Split mime-type into type and extension
        $mimeType = explode('/', $mimeType);

        return ($mimeType[0] == 'image') ? 'images/original' : 'data';
    }
}
