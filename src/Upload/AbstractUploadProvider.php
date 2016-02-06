<?php
namespace Nodes\Assets\Upload;

use finfo;
use Illuminate\Support\Str;
use Nodes\Assets\Support\DataUri;
use Nodes\Assets\Upload\Exceptions\AssetsBadRequestException;
use Nodes\Assets\Upload\Exceptions\AssetsNoContentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AbstractUploadProvider
 *
 * @package Nodes\Assets\Upload
 */
abstract class AbstractUploadProvider implements ProviderInterface
{
    /**
     * Process file
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @abstract
     * @access protected
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     * @return $path
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    protected abstract function store(UploadedFile $uploadedFile, Settings $settings);

    /**
     * Save/Upload an uploaded file
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  string                                              $folder
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     * @return string $path
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    public function addFromUpload(UploadedFile $uploadedFile, $folder, Settings $settings)
    {
        // Set folder
        if (!$settings->hasFolder()) {
            $settings->setFolder($folder);
        }

        // Generate filename
        if (!$settings->hasFilename()) {
            $settings->setFileName($this->generateFilename($uploadedFile));
        }

        // Generate file extension
        if (!$settings->hasFileExtension()) {
            $settings->setFileExtension($this->generateFileExtension($uploadedFile));
        }

        // Throw exception if required data is missing
        $settings->checkRequiredData();

        // Process uploaded file
        return $this->store($uploadedFile, $settings);
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
    public function addFromUrl($url, $folder, Settings $settings)
    {
        // Stream file from URL
        $streamContextOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ];

        $content = @file_get_contents($url, false, stream_context_create($streamContextOptions));

        if (empty($content)) {
            throw (new AssetsBadRequestException('Could not stream content from given URL'))->setStatusCode(400);
        }

        // Write streamed content to temp. file
        $file = tempnam('/tmp', '');
        file_put_contents($file, $content);

        // File's mime-type
        $mimeType = (new finfo(FILEINFO_MIME))->file($file);

        // Parse URL
        $pathInfo = pathinfo($url);

        // Generate an UploadedFile object
        $uploadedFile = new UploadedFile($file, $pathInfo['basename'], $mimeType, filesize($file));

        // Set folder
        if (!$settings->hasFolder()) {
            $settings->setFolder($folder);
        }

        // Generate filename
        if (!$settings->hasFilename()) {
            $settings->setFileName($this->generateFilename($uploadedFile));
        }

        // Generate file extension
        if (!$settings->hasFileExtension()) {
            $settings->setFileExtension($this->generateFileExtension($uploadedFile));
        }

        // Throw exception if required data is missing
        $settings->checkRequiredData();

        // Process file
        return $this->store($uploadedFile, $settings);
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
    public function addFromDataUri($dataUri, $folder, Settings $settings)
    {
        // Data URI container
        $dataUriObject = null;

        // Try and parse data URI to our container
        if (!DataUri::tryParse($dataUri, $dataUriObject)) {
            throw (new AssetsBadRequestException('Could not stream the content'))->setStatusCode(400);
        }

        // Retrieve the data
        $content = $dataUriObject->getEncodedData();

        // Write parsed content to temp. file
        $file = tempnam('/tmp', '');
        file_put_contents($file, base64_decode($content));

        // File's mime-type
        $mimeType = (new finfo(FILEINFO_MIME))->file($file);

        if (!in_array(explode(';', $mimeType)[0], config('nodes.assets.providers.nodes.imageExtensionMimeTypes'))) {
            throw (new AssetsBadRequestException('Invalid stream mime type'))->setStatusCode(400);
        }

        // Generate an UploadedFile object
        $uploadedFile = new UploadedFile($file, Str::random(10) . '.' . $dataUriObject->getFileExtension(), $mimeType, filesize($file));

        // Set folder
        if (!$settings->hasFolder()) {
            $settings->setFolder($folder);
        }

        // Generate filename
        if (!$settings->hasFilename()) {
            $settings->setFileName($this->generateFilename($uploadedFile));
        }

        // Generate file extension
        if (!$settings->hasFileExtension()) {
            $settings->setFileExtension($this->generateFileExtension($uploadedFile));
        }

        // Throw exception if required data is missing
        $settings->checkRequiredData();

        // Process file
        return $this->store($uploadedFile, $settings);
    }

    /**
     * Generate filename
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access protected
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @return string
     */
    protected function generateFilename(UploadedFile $uploadedFile)
    {
        // Retrieve original file name
        $filePath = $uploadedFile->getClientOriginalName();

        // Parse URL
        $filePath = pathinfo($filePath);

        // Sanitize filename
        $filename = preg_replace('/[^a-z0-9_-]/ui', '', $filePath['filename']);

        // Append random sting and extension to filename
        $filename .= '_' . Str::random(10);

        return $filename;
    }

    /**
     * Generate file extension
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @return string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     */
    public function generateFileExtension(UploadedFile $uploadedFile)
    {
        // Retrieve original file name
        $filePath = $uploadedFile->getClientOriginalName();

        // Parse URL
        $fileInfo = pathinfo($filePath);

        // Return extension is available
        if (!empty($fileInfo['extension'])) {
            return $fileInfo['extension'];
        }

        throw (new AssetsBadRequestException('Cannot detect file extension, provide it before uploading.'))->setStatusCode(400);
    }
}
