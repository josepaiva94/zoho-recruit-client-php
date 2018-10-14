<?php
namespace Apora\ZohoRecruitClient\Transport;

use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;

/**
 * Interface implemented by classes that add sugar to do HTTP calls to Zoho
 */
interface Transport
{
    /**
     * @param string $module    Zoho Recruit API module
     * @param string $method    Zoho Recruit API method
     * @param array  $paramList Parameters for call
     *
     * @return Record|Record[]|Field|Field[]|Result|Result[]|bool Result of the call
     */
    public function call($module, $method, array $paramList);
}
