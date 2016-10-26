<?php

namespace Nodes\Assets\Upload\Providers;

use Exception;
use Nodes\Assets\Upload\AbstractUploadProvider;
use Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException;
use Nodes\Assets\Upload\Settings;
use Nodes\Exceptions\Exception as NodesException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PublicFolder.
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 */
class PublicFolder extends AbstractUploadProvider
{
    /**
     * Save file to folder.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
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
        if (! $settings->hasFolder()) {
            $settings->setFolder('default');
        }

        try {
            // Retrieve folder path
            $path = public_path(config('nodes.assets.providers.publicFolder.subFolder')).DIRECTORY_SEPARATOR.$settings->getFolder();

            // If folder doesn't exists,
            // we'll create it with global permissions
            if (! file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // Stream uploaded file
            $content = file_get_contents($uploadedFile->getPathname());

            // Save uploaded file to folder
            $result = file_put_contents($path.DIRECTORY_SEPARATOR.$settings->getFileName().'.'.$settings->getFileExtension(),
                $content);

            if (! $result) {
                throw new NodesException('Failed to save', 500);
            }
        } catch (Exception $e) {
            throw new AssetsUploadFailedException('Could not save the file to public folder. Reason: '.$e->getMessage());
        }

        return $settings->getFilePath();
    }
}
