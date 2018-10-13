<?php

namespace Apora\ZohoRecruitClient\Transport;

/**
 * Interface implemented by classes that add sugar to do HTTP calls to Zoho
 *
 * @package Apora\ZohoRecruitClient\Transport
 */
interface Transport
{
    /**
     * @param string $module    Zoho Recruit API module
     * @param string $method    Zoho Recruit API method
     * @param array  $paramList Parameters for call
     * @return string Result of the call
     */
    public function call($module, $method, array $paramList);
}
