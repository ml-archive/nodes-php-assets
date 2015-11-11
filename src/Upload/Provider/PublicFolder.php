<?php
namespace Nodes\Assets\Upload\Provider;

use Nodes\Assets\Upload\AbstractUploadProvider;
use Nodes\Assets\Upload\Exception\AssetUploadFailedException;
use Nodes\Assets\Upload\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PublicFolder
 * @author  Casper Rasmussen <cr@nodes.dk>
 *
 * @package Nodes\Assets\Upload\Provider
 */
class PublicFolder extends AbstractUploadProvider
{
    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Nodes\Assets\Upload\Settings                       $settings
     * @return string
     * @throws \Nodes\Assets\Upload\Exception\AssetUploadFailedException
     */
    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        try {
            $path = public_path(config('nodes.assetsv2.provider.publicFolder.uploads')) . DIRECTORY_SEPARATOR . $settings->getFolder();
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $content = file_get_contents($uploadedFile->getRealPath());
            $result = file_put_contents($path . DIRECTORY_SEPARATOR . $settings->getFileName(), $content);
            if (!$result) {
                throw new \Exception('Failed to save');
            }

        } catch (\Exception $e) {
            throw new AssetUploadFailedException('Could not save the file to public folder. Reason: ' . $e->getMessage());
        }

        return $settings->getFilePath();
    }
}
