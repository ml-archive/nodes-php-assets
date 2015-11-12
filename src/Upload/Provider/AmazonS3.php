<?php
namespace Nodes\Assets\Upload\Provider;

use Aws\Common\Aws;
use Nodes\Assets\Upload\AbstractUploadProvider;
use Nodes\Assets\Upload\Exception\AssetsBadRequestException;
use Nodes\Assets\Upload\Exception\AssetsUploadFailedException;
use Nodes\Assets\Upload\Settings;
use Nodes\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class AmazonS3
 * @author  Casper Rasmussen <cr@nodes.dk>
 *
 * @package Nodes\Assets\Upload\Provider
 */
class AmazonS3 extends AbstractUploadProvider
{
    /**
     * @var \Aws\S3\S3Client
     */
    protected $s3;

    /**
     * @var string
     */
    protected $bucket;

    public function __construct(array $s3Config)
    {
        if (empty($s3Config) || $s3Config['key'] == 'your-key') {
            throw new AssetsBadRequestException('Missing credentials for s3 - These can be found in config/filesystems');
        }

        $this->s3 = Aws::factory($s3Config)->get('s3');

        $this->bucket = $s3Config['bucket'];
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     * @param \Nodes\Assets\Upload\Settings                       $settings
     * @return string
     * @throws \Nodes\Assets\Upload\Exception\AssetsUploadFailedException
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
