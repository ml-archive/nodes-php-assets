<?php

namespace Nodes\Assets\Upload\Providers;

use Nodes\Assets\Upload\AbstractUploadProvider;
use Nodes\Assets\Upload\Exceptions\AssetsBadRequestException;
use Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException;
use Nodes\Assets\Upload\Settings;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AmazonS3
 *
 * @package Nodes\Assets\Upload\Providers
 */
class AmazonS3 extends AbstractUploadProvider
{
    /** @var string */
    protected $bucket;

    /** @var string|null */
    protected $folder;

    /**
     * AmazonS3 constructor
     *
     * @param array $awsS3Config
     * @param array $s3Config
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access public
     */
    public function __construct(array $awsS3Config, array $s3Config)
    {
        // Validate credentials
        if (empty($s3Config) || $s3Config['key'] == 'your-key'|| $s3Config['secret'] == "AMAZON_SECRET" ||
                                                                                        $s3Config['region'] == "AMAZON_REGION" ||
                                                                                                              $s3Config['bucket'] == "AMAZON_BUCKET") {
            throw ( new AssetsBadRequestException('Missing credentials for s3 - These can be found in config/filesystems') )->setStatusCode(400);
        }

        // Set S3 bucket
        $this->bucket = $s3Config['bucket'];
        $this->folder = $awsS3Config['folder'];
    }

    /**
     * Upload file to S3.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     *
     * @return string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        $path = '';

        if($this->folder) {
            $path .= $this->folder . DIRECTORY_SEPARATOR;
        }

        $path .= $settings->getFilePath();

        try {
            // Upload to bucket
            \Storage::disk('s3')->put($path, file_get_contents($uploadedFile->getRealPath()));
        } catch (\Exception $e) {
            throw new AssetsUploadFailedException('Could not upload file to Amazon S3. Reason: '.$e->getMessage());
        }

        return $path;
    }
}
