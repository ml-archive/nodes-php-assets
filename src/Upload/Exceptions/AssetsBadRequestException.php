<?php
namespace Nodes\Assets\Upload\Exceptions;

use Nodes\Exceptions\Exception as NodesException;

/**
 * Class AssetsBadRequestException
 *
 * @package Nodes\Assets\Exception
 */
class AssetsBadRequestException extends NodesException
{
    /**
     * AssetsBadRequestException constructor
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @access public
     * @param  string  $message
     * @param  integer $code
     * @param  array   $headers
     * @param  boolean $report
     */
    public function __construct($message, $code = 400, $headers = [], $report = false)
    {
        parent::__construct($message, $code, $headers, $report);
    }
}
