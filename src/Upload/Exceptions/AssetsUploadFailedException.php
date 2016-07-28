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
     * AssetsUploadFailedException constructor
     *
     * @author Morten Rugaard <moru@nodes.dk>
     * @access public
     *
     * @param  string  $message
     * @param  integer $code
     * @param  array   $headers
     * @param  boolean $report
     */
    public function __construct($message, $code = 500, $headers = [ ], $report = false)
    {
        parent::__construct($message, $code, $headers, $report);
    }
}
