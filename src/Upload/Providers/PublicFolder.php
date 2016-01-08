<?php
namespace Nodes\Assets\Upload\Providers;

use Exception;
use Nodes\Exceptions\Exception as NodesException;
use Nodes\Assets\Upload\AbstractUploadProvider;
use Nodes\Assets\Upload\Exceptions\AssetUploadFailedException;
use Nodes\Assets\Upload\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PublicFolder
 * @author  Casper Rasmussen <cr@nodes.dk>
 *
 * @package Nodes\Assets\Upload\Providers
 */
class PublicFolder extends AbstractUploadProvider
{
    /**
     * Save file to folder
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access protected
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     * @return string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetUploadFailedException
     */
    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        try {
            // Retrieve folder path
            $path = public_path(config('nodes.assetsv2.provider.publicFolder.uploads')) . DIRECTORY_SEPARATOR . $settings->getFolder();

            // If folder doesn't exists,
            // we'll create it with global permissions
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Stream uploaded file
            $content = file_get_contents($uploadedFile->getRealPath());

            // Save uploaded file to folder
            $result = file_put_contents($path . DIRECTORY_SEPARATOR . $settings->getFileName(), $content);
            if (!$result) {
                throw new NodesException('Failed to save');
            }
        } catch (Exception $e) {
            throw new AssetUploadFailedException('Could not save the file to public folder. Reason: ' . $e->getMessage());
        }

        return $settings->getFilePath();
    }
}
