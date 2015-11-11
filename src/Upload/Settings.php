<?php

namespace Nodes\Assets\Upload;

use Nodes\Assets\Upload\Exception\AssetBadRequestException;

/**
 * Class Settings
 *
 * @author  Casper Rasmussen <cr@nodes.dk>
 * @package Nodes\Assets\Upload
 */
class Settings
{
    /**
     * @var string|null
     */
    protected $folder;

    /**
     * @var string|null
     */
    protected $fileExtension;

    /**
     * @var string|null
     */
    protected $fileName;

    /**
     * Make sure the required data for storing
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @throws \Nodes\Assets\Upload\Exception\AssetBadRequestException
     */
    public function checkRequiredData()
    {
        if (!$this->hasFilename()) {
            throw new AssetBadRequestException('Missing filename, cannot upload with a empty filename');
        }

        if (!$this->hasFileExtension()) {
            throw new AssetBadRequestException('Missing file extension, cannot upload with a empty file extension');
        }
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return bool
     */
    public function hasFilename()
    {
        return boolval($this->fileName);
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return null|string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param $fileName
     * @return \Nodes\Assets\Upload\Settings
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return bool
     */
    public function hasFileExtension()
    {
        return !empty($this->fileExtension);
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return string|null
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param $fileExtension
     * @return \Nodes\Assets\Upload\Settings
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return bool
     */
    public function hasFolder()
    {
        return boolval($this->folder);
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return string
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @author Casper Rasmussen <cr@nodes.dk>
     * @param $folder
     * @return \Nodes\Assets\Upload\Settings
     */
    public function setFolder($folder)
    {
        if (!$folder) {
            $this->folder = config('nodes.assetsv2.general.default.folder');
        } else {
            $this->folder = $folder;
        }

        return $this;
    }

    /**
     * return folder/filename
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     * @return string
     */
    public function getFilePath()
    {
        $path = $this->fileName . '.' . $this->fileExtension;

        if($this->hasFolder()) {
            $path = $this->folder . DIRECTORY_SEPARATOR . $path;
        }

        return $path;
    }
}