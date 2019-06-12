<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CDN Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL of our Amazon CDN. This will be prefixed with on image
    | that'll be retrieved from via Nodes Assets.
    |
    | Without protocol and without trailing slash.
    |
    */
    'url' => env('AMAZON_CLOUDFRONT_URL'),
];
