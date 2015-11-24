<?php
namespace Nodes\Assets\Upload\Exceptions;

use Nodes\Exceptions\Exception as NodesException;

/**
 * Class AssetsUploadFailedException
 *
 * @package Nodes\Assets\Exceptions
 */
class AssetsUploadFailedException extends NodesException
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
    public function __construct($message, $statusCode = 500, $statusCodeMessage = null, $report = false)
    {
        parent::__construct($message, $statusCode, $statusCodeMessage, $report);
    }
}
