<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve Associated JobOpenings of a given Candidate
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class GetAssociatedJobOpenings extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getAssociatedJobOpenings')
            ->setParam('version', 2);
    }

    /**
     * Specify unique ID of the Candidate record
     *
     * @param string $id
     * @return GetAssociatedJobOpenings
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);
        return $this;
    }
}
