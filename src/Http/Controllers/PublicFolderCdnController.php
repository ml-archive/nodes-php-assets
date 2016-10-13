<?php

declare(strict_types = 1);

namespace Nodes\Assets\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nodes\Assets\Http\Requests\CdnRequest;
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
     * @author Pedro Coutinho <peco@nodesagency.com>
     *
     * @param \Nodes\Assets\Http\Requests\CdnRequest $request
     * @param string                                 $folder
     * @param string                                 $file
     *
     * @return mixed
     */
    public function cdn(CdnRequest $request, $folder, $file)
    {
        $mode = 'resize';

        $width  = null;
        $height = null;

        $path = $folder.'/'.$file;

        if ($request->has('mode')) {
            $mode = $request->get('mode');
        }

        if ($request->has('width')) {
            $width = $request->get('width');
        }

        if ($request->has('height')) {
            $height = $request->get('height');
        }

        if ($request->has('w')) {
            $width = $request->get('w');
        }

        if ($request->has('h')) {
            $height = $request->get('h');
        }

        return app(PublicFolderCache::class)->cache($path, $width, $height, $mode);
    }
}
