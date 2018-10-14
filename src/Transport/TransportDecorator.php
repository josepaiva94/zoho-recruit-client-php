<?php
namespace Apora\ZohoRecruitClient\Transport;

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
     * @return string Result of the call
     */
    abstract public function call($module, $method, array $paramList);
}
