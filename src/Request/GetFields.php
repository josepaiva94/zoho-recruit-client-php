<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve details of fields available in a module
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class GetFields extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getFields')
            ->setParam('version', 2);
    }

    /**
     * Specify the type, if you do not want to retrieve all fields from the module
     *      1 - To retrieve all fields from the summary view
     *      2 - To retrieve all mandatory fields from the module
     *
     * @param int $type
     * @return GetFields
     */
    public function type($type)
    {
        $this->transporter->setParam('type', $type);
        return $this;
    }
}
