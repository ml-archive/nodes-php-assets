<?php
if (!function_exists('assets_get')) {
    /**
     * Retrieve URL of asset path
     *
     * @author Casper Rasmussen <cr@nodes.dk>
     *
     * @param                                 $path
     * @param \Nodes\Assets\Url\Settings|null $settings
     * @return string $url
     */
    function assets_get($path, \Nodes\Assets\Url\Settings $settings = null)
    {
        return \Assets::get($path, $settings);
    }
}