<?php
namespace Nodes\Assets\Upload\Exception;

use Nodes\Exception\Exception;

/**
 * Class AssetsBadRequestException
 *
 * @package Nodes\Assets\Exception
 */
class AssetsBadRequestException extends Exception
{
    /**
     * Constructor
     *
     * @author Morten Rugaard <moru@nodes.dk>
     *
     * @access public
     * @param  string  $message
     * @param  integer $statusCode
     * @param  string  $statusCodeMessage
     * @param  boolean $report
     */
    public function __construct($message, $statusCode = 400, $statusCodeMessage = null, $report = false)
    {
        parent::__construct($message, $statusCode, $statusCodeMessage, $report);
    }
}
