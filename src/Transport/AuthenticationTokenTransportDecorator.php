<?php
namespace Apora\ZohoRecruitClient\Transport;

/**
 * Transport decorator that adds the authentication token and scope
 */
class AuthenticationTokenTransportDecorator extends TransportDecorator
{
    private $authToken;

    public function __construct($authToken, Transport $transport)
    {
        $this->authToken = $authToken;
        parent::__construct($transport);
    }

    /**
     * @param string $module    Zoho Recruit API module
     * @param string $method    Zoho Recruit API method
     * @param array  $paramList Parameters for call
     *
     * @return string Result of the call
     */
    public function call($module, $method, array $paramList)
    {
        $paramList['authtoken'] = $this->authToken;
        $paramList['scope'] = 'recruitapi';

        return $this->transport->call($module, $method, $paramList);
    }
}
