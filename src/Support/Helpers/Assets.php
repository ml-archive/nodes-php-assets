<?php

use Nodes\Assets\Upload\Settings as UploadSettings;
use Nodes\Assets\Url\Settings as UrlSettings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

if (!function_exists('assets_get')) {

    function assets_get($path, UrlSettings $settings = null)
    {
        return \Assets::get($path, $settings);
    }
}

if (!function_exists('assets_add')) {

    function assets_add($file, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::add($file, $folder, $settings);
    }
}

if (!function_exists('assets_add_uploaded_file')) {

    function assets_add_uploaded_file(UploadedFile $file, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::addFromUploadedFile($file, $folder, $settings);
    }
}

if (!function_exists('assets_add_url')) {

    function assets_add_url($url, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::addFromUrl($url, $folder, $settings);
    }
}

if (!function_exists('assets_add_data_uri')) {

    function assets_add_data_uri($dataUri, $folder = null, UploadSettings $settings = null)
    {
        return \Assets::addFromDataUri($dataUri, $folder, $settings);
    }
}