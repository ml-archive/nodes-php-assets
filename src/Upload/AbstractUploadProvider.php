<?php
namespace Nodes\Assets\Upload;

use finfo;
use Illuminate\Support\Str;
use Nodes\Assets\Support\DataUri;
use Nodes\Assets\Upload\Exception\AssetBadRequestException;
use Nodes\Assets\Upload\Exception\AssetNoContentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AbstractUploadProvider
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 * @package Nodes\Assets\Upload
 */
abstract class AbstractUploadProvider implements ProviderInterface
{
    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Nodes\Assets\Upload\Settings                       $settings
     * @return mixed
     */
    protected abstract function store(UploadedFile $uploadedFile, Settings $settings);

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param                                                     $folder
     * @param \Nodes\Assets\Upload\Settings                       $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exception\AssetBadRequestException
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

        // Throw exception if some data is missing
        $settings->checkRequiredData();

        // Store
        return $this->store($uploadedFile, $settings);
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param                               $url
     * @param                               $folder
     * @param \Nodes\Assets\Upload\Settings $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exception\AssetBadRequestException
     * @throws \Nodes\Assets\Upload\Exception\AssetNoContentException
     */
    public function addFromUrl($url, $folder, Settings $settings)
    {
        $content = @file_get_contents($url);
        if (empty($content)) {
            throw new AssetNoContentException('Could not stream content from given URL');
        }

        // Write content to temporary file
        $file = tempnam('/tmp', '');
        file_put_contents($file, $content);

        // File type
        $mimeType = (new finfo(FILEINFO_MIME))->file($file);

        // Parse URL
        $pathInfo = pathinfo($url);

        // Generate a UploadedFile
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

        // Throw exception if some data is missing
        $settings->checkRequiredData();

        // Store
        return $this->store($uploadedFile, $settings);
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param                               $dataUri
     * @param                               $folder
     * @param \Nodes\Assets\Upload\Settings $settings
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exception\AssetBadRequestException
     * @throws \Nodes\Assets\Upload\Exception\AssetNoContentException
     */
    public function addFromDataUri($dataUri, $folder, Settings $settings)
    {

        $dataUriObject = null;
        if(!DataUri::tryParse($dataUri, $dataUriObject)) {
            throw new AssetNoContentException('Could not stream the content');
        }

        $content = $dataUriObject->getEncodedData();

        // Write content to temporary file
        $file = tempnam('/tmp', '');
        file_put_contents($file, base64_decode($content));

        // File type
        $mimeType = (new finfo(FILEINFO_MIME))->file($file);

        // Generate a UploadedFile
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

        // Throw exception if some data is missing
        $settings->checkRequiredData();

        // Store
        return $this->store($uploadedFile, $settings);
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @return mixed|string
     */
    protected function generateFilename(UploadedFile $uploadedFile)
    {
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
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @return mixed
     * @throws \Nodes\Assets\Upload\Exception\AssetBadRequestException
     */
    public function generateFileExtension(UploadedFile $uploadedFile)
    {
        $filePath = $uploadedFile->getClientOriginalName();
        $fileInfo = pathinfo($filePath);

        if(isset($fileInfo['extension'])) {
            return $fileInfo['extension'];
        }

        throw new AssetBadRequestException('Cannot detect file extension, provide it before uploading');
    }
}
