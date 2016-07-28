<?php
if ( ! function_exists('assets_get')) {
    /**
     * Retrieve URL of asset path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param                                 $path
     *
     * @return string $url
     */
    function assets_get($path)
    {
        return app('nodes.assets')->get($path);
    }
}

if ( ! function_exists('assets_resize')) {

    /**
     * Append a query with h and w after the image url
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param      $url
     * @param bool $width
     * @param bool $height
     *
     * @return string
     */
    function assets_resize($url, $width = false, $height = false)
    {
        // Validate the url
        if ( ! filter_var($url, FILTER_VALIDATE_URL)) {
            return $url;
        }

        // Init query
        $query = [];

        // Add w query param
        if ($width && is_numeric($width) && $width > 0) {
            $query['w'] = (int)$width;
        }

        // Add h query param
        if ($height && is_numeric($height) && $height > 0) {
            $query['h'] = (int)$height;
        }

        // Check if query is empty
        if (empty($query)) {
            return $url;
        }

        // Append the query string
        return $url.'?'.http_build_query($query);
    }
}
