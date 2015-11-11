<?php
namespace Nodes\Assets\Upload\Provider;

use Nodes\Assets\Upload\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class NodesS3
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 * @package Nodes\Assets\Upload\Provider
 */
class NodesS3 extends AmazonS3
{
    public function __construct(array $s3Config, array $nodesConfig) {
        parent::__construct($s3Config);
    }

    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        if(!$settings->hasFolder()) {
            $settings->setFolder('default');
        }

        $returnPath = $settings->getFilePath();
        $settings->setFolder($this->getPath($uploadedFile, $settings));

        parent::store($uploadedFile, $settings);

        return $returnPath;
    }

    private function getPath(UploadedFile $uploadedFile, Settings $settings) {
        return env('APP_NAME') .
        DIRECTORY_SEPARATOR .
        $this->getSubFolder($uploadedFile) .
        DIRECTORY_SEPARATOR .
        $settings->getFolder();
    }

    private function getSubFolder(UploadedFile $uploadedFile)
    {
        // Find mime type
        $mimeType = $uploadedFile->getMimeType();

        // Clean mime-type for charset and other unneeded stuff
        if (strpos($mimeType, ';')) {
            $mimeType = explode(';', $mimeType);
            return strtolower($mimeType[0]);
        }
        $mimeType = strtolower($mimeType);

        // Split mime-type into type and extension
        $mimeType = explode('/', $mimeType);

        return ($mimeType[0] == 'image') ? 'images/original' : 'data';
    }
}
