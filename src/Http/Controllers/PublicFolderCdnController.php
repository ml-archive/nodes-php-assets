<?php

declare(strict_types=1);

namespace Nodes\Assets\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nodes\Assets\Support\PublicFolderCache;

/**
 * Class PublicFolderCdn.
 */
class PublicFolderCdnController extends Controller
{
    /**
     * Assets CDN endpoint.
     *
     * @author Jonas Schwartz <josc@nodes.dk>
     * @param Request $request
     * @param $folder
     * @param $file
     * @return mixed
     */
    public function cdn(Request $request, $folder, $file)
    {
        $mode = 'resize';
        $width = null;
        $height = null;

        $input = $request->input();

        $path = $folder.'/'.$file;

        if (isset($input['mode'])) {
            $mode = $input['mode'];
        }

        if (isset($input['width'])) {
            $width = $input['width'];
        }

        if (isset($input['height'])) {
            $height = $input['height'];
        }

        if (isset($input['w'])) {
            $width = $input['w'];
        }

        if (isset($input['h'])) {
            $height = $input['h'];
        }

        return app(PublicFolderCache::class)->cache($path, $width, $height, $mode);
    }
}
