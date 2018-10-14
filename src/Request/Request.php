<?php
namespace Apora\ZohoRecruitClient\Request;

use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;
use Apora\ZohoRecruitClient\Transport\RequestTransporter;

/**
 * Interface implemented by all public API requests
 */
interface Request
{
    /**
     * @param RequestTransporter $transporter
     */
    public function __construct(RequestTransporter $transporter);

    /**
     * @return Record|Record[]|Field|Field[]|Result|Result[]|bool
     */
    public function request();
}
