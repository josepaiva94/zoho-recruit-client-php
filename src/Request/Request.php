<?php

namespace Apora\ZohoRecruitClient\Request;

use Apora\ZohoRecruitClient\Transport\RequestTransporter;

/**
 * Interface implemented by all public API requests
 *
 * @package Apora\ZohoRecruitClient\Request
 */
interface Request
{
    /**
     * @param RequestTransporter $transporter
     */
    public function __construct(RequestTransporter $transporter);

    /**
     * @return array
     */
    public function request();
}