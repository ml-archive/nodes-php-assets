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
class AmazonS3 extends AbstractUploadProvider {

	/**
	 * Name of bucket
	 *
	 * @var string
	 */
	protected $bucket;


	/**
	 * AmazonS3 constructor
	 *
	 * @author Morten Rugaard <moru@nodes.dk>
	 * @access public
	 *
	 * @param  array $s3Config
	 *
	 * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
	 */
	public function __construct(array $s3Config)
	{
		// Validate credentials
		if (empty($s3Config) || $s3Config['key'] == 'your-key')
		{
			throw (new AssetsBadRequestException('Missing credentials for s3 - These can be found in config/filesystems'))->setStatusCode(400);
		}

		// Set S3 bucket
		$this->bucket = $s3Config['bucket'];
	}


	/**
	 * Upload file to S3
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access protected
	 *
	 * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
	 * @param  \Nodes\Assets\Upload\Settings                       $settings
	 *
	 * @return string
	 * @throws \Nodes\Assets\Upload\Exceptions\AssetsUploadFailedException
	 */
	protected function store(UploadedFile $uploadedFile, Settings $settings)
	{
		try
		{
			// Upload to bucket
			\Storage::disk('s3')->put($settings->getFilePath(), file_get_contents($uploadedFile->getRealPath()));
		} catch (\Exception $e)
		{
			throw new AssetsUploadFailedException('Could not upload file to Amazon S3. Reason: ' . $e->getMessage());
		}

		return $settings->getFilePath();
	}
}
