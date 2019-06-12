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
            $vaporCloudConfig = config('nodes.assets.providers.vapor-cloud');

            return new \Nodes\Assets\Upload\Providers\VaporCloud($s3Config, $vaporCloudConfig);
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
            $vaporCloudConfig = config('nodes.assets.providers.vapor-cloud');

            return new \Nodes\Assets\Url\Providers\VaporCloud($vaporCloudConfig);
        },
    ],
];
