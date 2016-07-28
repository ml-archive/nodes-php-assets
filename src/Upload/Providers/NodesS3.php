<?php
namespace Nodes\Assets\Upload\Providers;

use Nodes\Assets\Upload\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NodesS3
 *
 * @package Nodes\Assets\Upload\Providers
 */
class NodesS3 extends AmazonS3
{

    /**
     * NodesS3 constructor
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access public
     *
     * @param  array $s3Config
     * @param  array $nodesConfig
     *
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     */
    public function __construct(array $s3Config, array $nodesConfig)
    {
        parent::__construct($s3Config);
    }


    /**
     * Upload file to S3
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access protected
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     *
     * @return string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        // Fallback folder is none is set
        if ( ! $settings->hasFolder()) {
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
     * Retrieve path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access private
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     *
     * @return string
     */
    private function getPath(UploadedFile $uploadedFile, Settings $settings)
    {
        return env('APP_NAME').DIRECTORY_SEPARATOR.$this->getSubFolder($uploadedFile).DIRECTORY_SEPARATOR.$settings->getFolder();
    }


    /**
     * Retrieve sub folder
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @access private
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     *
     * @return string
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
