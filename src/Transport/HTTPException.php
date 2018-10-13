<?php

namespace Apora\ZohoRecruitClient\Transport;

use Apora\ZohoRecruitClient\Exception\Exception;

/**
 * Exception thrown when the status is not 200
 *
 * @package Apora\ZohoRecruitClient\Transport
 */
class HTTPException extends Exception
{
    /** @var int */
    private $statusCode;
    /** @var string */
    private $content;

    public function __construct($content, $statusCode)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        parent::__construct('Unexpected HTTP response with status code: ' . $statusCode);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
