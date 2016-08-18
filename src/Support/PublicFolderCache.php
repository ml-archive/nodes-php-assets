<?php

declare(strict_types=1);

namespace Nodes\Assets\Support;

/**
 * Class PublicFolderCache.
 */
class PublicFolderCache
{
    /**
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $path
     * @param null $width
     * @param null $height
     * @return mixed
     */
    public function cache($path, $width, $height, $mode)
    {
        if (empty($width) && empty($height)) {
            $path = $this->getFullPath($path);

            return $this->showFile($path);
        } else {
            $size = $width.'x'.$height;
            $cachePath = $this->fullCacheFilePath($path, $size, $mode);

            if (! $this->fileExists($cachePath)) {
                if ($mode == 'resize') {
                    return $this->resizeImage($path, $cachePath, $width, $height);
                } else {
                    return $this->cropImage($path, $cachePath, $width, $height);
                }
            } else {
                return $this->showFile($cachePath);
            }
        }
    }

    /**
     * Get full path to image.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $path
     * @return string
     */
    public function getFullPath($path)
    {
        return public_path(config('nodes.assets.providers.publicFolder.subFolder')).DIRECTORY_SEPARATOR.$path;
    }

    /**
     * Check if file exists.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $path
     * @return bool
     */
    public function fileExists($path)
    {
        $filePath = $this->getFullPath($path);

        return file_exists($filePath) ? true : false;
    }

    /**
     * Get full cache path.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $path
     * @param $size
     * @param $mode
     * @return string
     */
    public function fullCacheFilePath($path, $size, $mode)
    {
        return $this->getFullPath('cache/'.$mode.'/'.$size.'/'.$path);
    }

    /**
     * Resize the image.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $original
     * @param $path
     * @param $width
     * @param $height
     * @return mixed
     */
    public function resizeImage($original, $path, $width, $height)
    {
        $original = $this->getFullPath($original);

        // Create folder if it dosn't exist
        $pathArray = explode('/', $path);
        array_pop($pathArray);
        $folder = implode('/', $pathArray);
        if (! file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = \File::get($original);

        $img = \Image::make($file)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $img->save($path);

        return $this->showFile($path);
    }

    /**
     * Crop the image.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $original
     * @param $path
     * @param $width
     * @param $height
     * @return mixed
     */
    public function cropImage($original, $path, $width, $height)
    {
        $original = $this->getFullPath($original);

        // Create folder if it dosn't exist
        $pathArray = explode('/', $path);
        array_pop($pathArray);
        $folder = implode('/', $pathArray);
        if (! file_exists($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = \File::get($original);

        $img = \Image::make($file)->crop($width, $height);

        $img->save($path);

        return $this->showFile($path);
    }

    /**
     * Show the specified file in the browser.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param $path
     * @return mixed
     */
    public function showFile($path)
    {
        // We need to clean the output buffer before showing the file
        ob_end_clean();
        ob_start();

        $type = \File::mimeType($path);

        return response()->file($path, ['Content-Type' => $type]);
    }
}
