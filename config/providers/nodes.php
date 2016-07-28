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
	| Without protocol and with trailing slash.
	|
	*/
	'cloudfrontUrl'           => env('AMAZON_CLOUDFRONT_URL'),

	/*
	|--------------------------------------------------------------------------
	| CDN Base URL for data
	|--------------------------------------------------------------------------
	|
	| The base URL of our Amazon CDN. This will be prefixed with on data files
	| that'll be retrieved from via Nodes Assets.
	|
	| Without protocol and with trailing slash.
	|
	*/
	'cloudfrontUrlData'       => env('AMAZON_CLOUDFRONT_URL_DATA'),

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