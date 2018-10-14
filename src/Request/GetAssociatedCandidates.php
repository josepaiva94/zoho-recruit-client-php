<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to get associated Candidates for a Job Opening
 */
class GetAssociatedCandidates extends ZohoRecruitRequest
{
    /**
     * Specify uniqueID of the Job Opening record.
     *
     * @param string $id
     *
     * @return GetAssociatedCandidates
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);

        return $this;
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getAssociatedCandidates')
            ->setParam('version', 2);
    }
}
