<?php
namespace Nodes\Assets\Upload\Providers;

use Aws\Common\Aws;
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
    /**
     * S3 Client instance
     * @var \Aws\S3\S3Client
     */
    protected $s3;

    /**
     * Name of bucket
     * @var string
     */
    protected $bucket;

    /**
     * AmazonS3 constructor
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @access public
     * @param  array $s3Config
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
     */
    public function __construct(array $s3Config)
    {
        // Validate credentials
        if (empty($s3Config) || $s3Config['key'] == 'your-key') {
            throw (new AssetsBadRequestException('Missing credentials for s3 - These can be found in config/filesystems'))->setStatusCode(400);
        }

        // Initiate S3 instance
        $this->s3 = Aws::factory($s3Config)->get('s3');

        // Set S3 bucket
        $this->bucket = $s3Config['bucket'];
    }

    /**
     * Upload file to S3
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @access protected
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param  \Nodes\Assets\Upload\Settings                       $settings
     * @return string
     * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
     */
    protected function store(UploadedFile $uploadedFile, Settings $settings)
    {
        try {
            // Upload to bucket
            // When the aws is changed to v3 this line can be used instead of the lib
            //Storage::disk('local')->put($this->getPath($settings), file_get_contents($settings->getRealPath()));

            $this->s3->putObject([
                'Bucket' => $this->bucket,
                'Key' => $settings->getFilePath(),
                'SourceFile' => $uploadedFile->getRealPath(),
                'ACL' => 'public-read'
            ]);
        } catch (\Exception $e) {
            throw new AssetsUploadFailedException('Could not upload file to Amazon S3. Reason: ' . $e->getMessage());
        }

        return $settings->getFilePath();
    }
}
