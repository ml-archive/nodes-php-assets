<?php

namespace Nodes\Assets\Upload\Exceptions;

use Nodes\Exceptions\Exception as NodesException;

/**
 * Class AssetsBadRequestException.
 */
class AssetsBadRequestException extends NodesException
{
    /**
     * AssetsBadRequestException constructor.
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @param  string  $message
     * @param  int $code
     * @param  array   $headers
     * @param  bool $report
     */
    public function __construct($message, $code = 400, $headers = [], $report = false)
    {
        parent::__construct($message, $code, $headers, $report);
    }
}
