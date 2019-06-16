<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Folder
    |--------------------------------------------------------------------------
    |
    | Enforce a folder to be used, instead of root
    |
    |
    */
    'appName'                 => env('APP_NAME'),

    /*
    |--------------------------------------------------------------------------
    | CDN Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of our Amazon CDN. This will be prefixed with on image
    | that'll be retrieved from via Nodes Assets.
    |
    | Without protocol and with trailing slash.
    |
    */
    'cdnUrl'                  => env('AMAZON_CLOUDFRONT_URL'),

    /*
    |--------------------------------------------------------------------------
    | CDN Raw Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of our Amazon CDN. This will be prefixed with on image
    | that'll be retrieved from via Nodes Assets.
    |
    | Without protocol and with trailing slash.
    |
    */
    'cdnRawUrl'               => env('AMAZON_CLOUDFRONT_URL_DATA'),

    /*
   |--------------------------------------------------------------------------
   | Restructure CDN PATH
   |--------------------------------------------------------------------------
   |
   | Option to restructure url
   | This can be very handy with local env
   |
   */
    'generateCdnUrl'          => function (
        array $config,
        array $filePath,
        string $fileType,
        string $folder,
        string $schema
    ) {

        if(env('APP_ENV') == 'local') {
            if ($fileType == 'images') {
                // Generated URL for asset file
                return $schema . $config['cdnUrl'] . $config['appName'] . DIRECTORY_SEPARATOR . 'images/original' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR .
                       $filePath['basename'];
            } else {
                // Download and data folder path
                return $schema . $config['cdnRawUrl'] . $config['appName'] .
                       DIRECTORY_SEPARATOR . $fileType . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR .
                       $filePath['basename'];
            }
        }

        if ($fileType == 'images') {
            // Generated URL for asset file
            return $schema . $config['cdnUrl'] . 'image' . DIRECTORY_SEPARATOR . $config['appName'] .
                   DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $filePath['basename'];
        } else {
            // Download and data folder path
            return $schema . $config['cdnRawUrl'] . $config['appName'] .
                   DIRECTORY_SEPARATOR . $fileType . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR .
                   $filePath['basename'];
        }
    },
    /*
    |--------------------------------------------------------------------------
    | Mapping of file extension to mime types
    |--------------------------------------------------------------------------
    |
    | All mime types from this list will be put in the image folder
    | where there is support for resize
    |
    |
    */
    'imageExtensionMimeTypes' => [
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'pjpg'  => 'image/pjpeg',
        'pjpeg' => 'image/pjpeg',
        'png'   => 'image/png',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'svgz'  => 'image/svg+xml',
        'tiff'  => 'image/tiff',
    ],
];
