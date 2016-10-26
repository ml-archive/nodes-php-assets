<?php
/*
    |--------------------------------------------------------------------------
    | Settings for the PublicFolder Assets providers
    | Both upload and url
    |--------------------------------------------------------------------------
    */
return [
    /*
    |--------------------------------------------------------------------------
    | Sub folder
    |--------------------------------------------------------------------------
    |
    | Pick the path between public
    */
    'subFolder' => 'uploads',

    /*
    |--------------------------------------------------------------------------
    | Domain
    |--------------------------------------------------------------------------
    |
    | The domain of the public folder
    */
    'domain'    => env('APP_NAME').'.'.env('APP_DOMAIN'),

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
