<?php

namespace Nodes\Assets\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProviderInterface
{
    /**
     * Save/Upload an uploaded file.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  string                                              $folder
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     * @return string $path
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromUpload(UploadedFile $uploadedFile, $folder, Settings $settings);

    /**
     * Save/Upload file from URL.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  string                        $url
     * @param  string                        $folder
     * @param  \Nodes\Assets\Upload\Settings $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromUrl($url, $folder, Settings $settings);

    /**
     * Save/Upload file from a Data URI.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  string                        $dataUri
     * @param  string                        $folder
     * @param  \Nodes\Assets\Upload\Settings $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromDataUri($dataUri, $folder, Settings $settings);
}
