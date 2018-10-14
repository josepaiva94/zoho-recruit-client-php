<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve all modules from Zoho Recruit account
 */
class GetModules extends ZohoRecruitRequest
{
    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getModules')
            ->setParam('version', 2);
    }
}
