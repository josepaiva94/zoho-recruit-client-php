<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to associate candidates to job openings in Zoho Recruit
 */
class AssociateJobOpening extends ZohoRecruitRequest
{
    /**
     * Specify uniqueID of the Job Opening records for which the associated candidate status has to be changed.
     *
     * @param array|string $ids
     *
     * @return AssociateJobOpening
     */
    public function jobs($ids)
    {
        if (! is_array($ids)) {
            $ids = func_get_args();
        }
        $this->transporter->setParam('jobIds', implode(',', $ids));

        return $this;
    }

    /**
     * Specify candidate ids for which the status has to be changed, with respect to the job openings.
     *
     * @param array|string $ids
     *
     * @return AssociateJobOpening
     */
    public function candidates($ids)
    {
        if (! is_array($ids)) {
            $ids = func_get_args();
        }
        $this->transporter->setParam('candidateIds', implode(',', $ids));

        return $this;
    }

    /**
     * Specify the status of the candidate with respect to the job opening.
     *
     * @param string $status
     *
     * @return AssociateJobOpening
     */
    public function status($status)
    {
        $this->transporter->setParam('status', $status);

        return $this;
    }

    /**
     * Specify the comments for the change in status.
     *
     * @param string $comments
     *
     * @return AssociateJobOpening
     */
    public function comments($comments)
    {
        $this->transporter->setParam('comments', $comments);

        return $this;
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('associateJobOpening')
            ->setParam('version', 2);
    }
}
