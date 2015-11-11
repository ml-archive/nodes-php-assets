<?php
namespace Nodes\Assets\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProviderInterface
{

    public function addFromUrl($url, $folder, Settings $settings);


    public function addFromUpload(UploadedFile $file, $folder, Settings $settings);


    public function addFromDataUri($dataUri, $folder, Settings $settings);
}
