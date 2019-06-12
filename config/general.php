<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Upload provider
     |--------------------------------------------------------------------------
     |
     | Upload provider is used to store the assets to the picked system
     |
     */
    'upload' => [
        'provider' => function () {
            $s3Config = config('filesystems.disks.s3');
            $awsS3Config = config('nodes.assets.provider.aws-s3');
            return new \Nodes\Assets\Upload\Providers\AmazonS3($awsS3Config, $s3Config);
        },
    ],
    /*
     |--------------------------------------------------------------------------
     | Url provider
     |--------------------------------------------------------------------------
     |
     | Url provider is to generate urls matching the uploaded files
     |
     */
    'url'    => [
        'provider' => function () {
            $imgIxConfig = config('nodes.assets.providers.imgix');

            return new \Nodes\Assets\Url\Providers\ImgIX($imgIxConfig);
        },
    ],
];
