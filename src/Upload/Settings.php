<?php
namespace Nodes\Assets\Upload;

use Nodes\Assets\Upload\Exceptions\AssetsBadRequestException;

/**
 * Class Settings
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 * @package Nodes\Assets\Upload
 */
class Settings {

	/**
	 * Folder name
	 *
	 * @var string|null
	 */
	protected $folder;

	/**
	 * File extension
	 *
	 * @var string|null
	 */
	protected $fileExtension;

	/**
	 * Filename
	 *
	 * @var string|null
	 */
	protected $fileName;


	/**
	 * Validate required data
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return void
	 * @throws \Nodes\Assets\Upload\Exceptions\AssetsBadRequestException
	 */
	public function checkRequiredData()
	{
		// Validate filename
		if ( ! $this->hasFilename())
		{
			throw new AssetsBadRequestException('Missing filename, cannot upload with a empty filename');
		}

		// Validate file extension
		if ( ! $this->hasFileExtension())
		{
			throw new AssetsBadRequestException('Missing file extension, cannot upload with a empty file extension');
		}
	}


	/**
	 * Check if filename is present
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return boolean
	 */
	public function hasFilename()
	{
		return boolval($this->fileName);
	}


	/**
	 * Retrieve filename
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return string|null
	 */
	public function getFileName()
	{
		return $this->fileName;
	}


	/**
	 * Set filename
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 *
	 * @param  $fileName
	 *
	 * @return \Nodes\Assets\Upload\Settings
	 */
	public function setFileName($fileName)
	{
		$this->fileName = $fileName;

		return $this;
	}


	/**
	 * Check if file extension is present
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return boolean
	 */
	public function hasFileExtension()
	{
		return ! empty($this->fileExtension);
	}


	/**
	 * Retrieve file extension
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return string|null
	 */
	public function getFileExtension()
	{
		return $this->fileExtension;
	}


	/**
	 * Set file extension
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 *
	 * @param  $fileExtension
	 *
	 * @return \Nodes\Assets\Upload\Settings
	 */
	public function setFileExtension($fileExtension)
	{
		$this->fileExtension = $fileExtension;

		return $this;
	}


	/**
	 * Check if folder name is present
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return boolean
	 */
	public function hasFolder()
	{
		return boolval($this->folder);
	}


	/**
	 * Retrieve folder name
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return string|null
	 */
	public function getFolder()
	{
		return $this->folder;
	}


	/**
	 * Set folder name
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 *
	 * @param  string $folder
	 *
	 * @return \Nodes\Assets\Upload\Settings
	 */
	public function setFolder($folder)
	{
		$this->folder = ! empty($folder) ? $folder : config('nodes.assetsv2.general.default.folder');

		return $this;
	}


	/**
	 * Retrieve file path
	 *
	 * @author Casper Rasmussen <cr@nodes.dk>
	 * @access public
	 * @return string
	 */
	public function getFilePath()
	{
		// Generate filename with extension
		$path = $this->fileName . '.' . $this->fileExtension;

		// Prepend folder if present
		if ($this->hasFolder())
		{
			$path = $this->folder . DIRECTORY_SEPARATOR . $path;
		}

		return $path;
	}
}