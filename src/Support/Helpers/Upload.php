<?php

if (! function_exists('assets_add')) {
    /**
     * Upload asset by auto-detection.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  mixed                              $file
     * @param  string|null                        $folder
     * @param  \Nodes\Assets\Upload\Settings|null $settings
     * @return string $path
     */
    function assets_add($file, $folder = null, \Nodes\Assets\Upload\Settings $settings = null)
    {
        return app('nodes.assets')->add($file, $folder, $settings);
    }
}

if (! function_exists('assets_add_uploaded_file')) {
    /**
     * Upload asset by uploaded file.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  \Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @param  string|null                                         $folder
     * @param  \Nodes\Assets\Upload\Settings|null                  $settings
     * @return string $path
     */
    function assets_add_uploaded_file(\Symfony\Component\HttpFoundation\File\UploadedFile $file, $folder = null, \Nodes\Assets\Upload\Settings $settings = null)
    {
        return app('nodes.assets')->addFromUploadedFile($file, $folder, $settings);
    }
}

if (! function_exists('assets_add_url')) {
    /**
     * Upload asset from an URL.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  string                             $url
     * @param  string|null                        $folder
     * @param  \Nodes\Assets\Upload\Settings|null $settings
     * @return string $path
     */
    function assets_add_url($url, $folder = null, \Nodes\Assets\Upload\Settings $settings = null)
    {
        return app('nodes.assets')->addFromUrl($url, $folder, $settings);
    }
}

if (! function_exists('assets_add_data_uri')) {
    /**
     * Upload asset by Data URI.
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param  string                             $dataUri
     * @param  string|null                        $folder
     * @param  \Nodes\Assets\Upload\Settings|null $settings
     * @return string $path
     */
    function assets_add_data_uri($dataUri, $folder = null, \Nodes\Assets\Upload\Settings $settings = null)
    {
        return app('nodes.assets')->addFromDataUri($dataUri, $folder, $settings);
    }
}
