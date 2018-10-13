<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve all note types in the user account which will be useful while adding Notes through API
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class GetNoteTypes extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getNoteTypes')
            ->setParam('version', 2);
    }
}
