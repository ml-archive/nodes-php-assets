<?php

use Nodes\Assets\Upload\Settings as UploadSettings;
use Nodes\Assets\Url\Settings as UrlSettings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

if (!function_exists('assets_get')) {

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param                                 $path
     * @param \Nodes\Assets\Url\Settings|null $settings
     * @return string $url
     */
    function assets_get($path, UrlSettings $settings = null)
    {
        return \Assets::get($path, $settings);
    }
}

if (!function_exists('assets_add')) {

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param                                    $file
     * @param null                               $folder
     * @param \Nodes\Assets\Upload\Settings|null $settings
     * @return string $path
     */
    function assets_add($file, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::add($file, $folder, $settings);
    }
}

if (!function_exists('assets_add_uploaded_file')) {

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param string|null                                         $folder
     * @param \Nodes\Assets\Upload\Settings|null                  $settings
     * @return string $path
     */
    function assets_add_uploaded_file(UploadedFile $file, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::addFromUploadedFile($file, $folder, $settings);
    }
}

if (!function_exists('assets_add_url')) {

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param string                             $url
     * @param string|null                        $folder
     * @param \Nodes\Assets\Upload\Settings|null $settings
     * @return string $path
     */
    function assets_add_url($url, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::addFromUrl($url, $folder, $settings);
    }
}

if (!function_exists('assets_add_data_uri')) {

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param string                             $dataUri
     * @param string|null                        $folder
     * @param \Nodes\Assets\Upload\Settings|null $settings
     * @return string $path
     */
    function assets_add_data_uri($dataUri, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::addFromDataUri($dataUri, $folder, $settings);
    }
}