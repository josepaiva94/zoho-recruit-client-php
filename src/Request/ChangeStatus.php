<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to change the candidate status with respect to the job openings in Zoho Recruit
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class ChangeStatus extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('changeStatus')
            ->setParam('version', 2);
    }

    /**
     * Specify uniqueID of the Job Opening record for which the associated candidate status has to be changed.
     *
     * @param string $id
     * @return ChangeStatus
     */
    public function job($id)
    {
        $this->transporter->setParam('jobId', $id);
        return $this;
    }

    /**
     * Specify candidate ids for which the status has to be changed, with respect to the job opening.
     *
     * @param array|string $ids
     * @return ChangeStatus
     */
    public function candidates($ids)
    {
        if (!is_array($ids)) {
            $ids = func_get_args();
        }
        $this->transporter->setParam('candidateIds', implode(',', $ids));
        return $this;
    }

    /**
     * Specify the status of the candidate with respect to the job opening.
     *
     * @param string $status
     * @return ChangeStatus
     */
    public function status($status)
    {
        $this->transporter->setParam('candidateStatus', $status);
        return $this;
    }

    /**
     * Specify the comments for the change in status.
     *
     * @param string $comments
     * @return ChangeStatus
     */
    public function comments($comments)
    {
        $this->transporter->setParam('comments', $comments);
        return $this;
    }
}
