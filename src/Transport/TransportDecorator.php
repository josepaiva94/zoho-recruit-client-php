<?php
namespace Apora\ZohoRecruitClient\Transport;

use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;

/**
 * Base abstract Transport decorator
 */
abstract class TransportDecorator implements Transport
{
    protected $transport;

    /**
     * @param Transport $transport
     */
    public function __construct(Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * @param string $module    Zoho Recruit API module
     * @param string $method    Zoho Recruit API method
     * @param array  $paramList Parameters for call
     *
     * @return Record|Record[]|Field|Field[]|Result|Result[]|bool Result of the call
     */
    abstract public function call($module, $method, array $paramList);
}
