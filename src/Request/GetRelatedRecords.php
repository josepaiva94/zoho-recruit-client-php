<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve records related to a primary module
 */
class GetRelatedRecords extends ZohoRecruitRequest
{
    /**
     * Set the offset index of the first record (for pagination)
     *
     * @param int $index
     *
     * @return GetRelatedRecords
     */
    public function fromIndex($index)
    {
        $this->transporter->setParam('fromIndex', (int) $index);

        return $this;
    }

    /**
     * Set the page size
     *
     * @param int $size
     *
     * @return GetRelatedRecords
     */
    public function pageSize($size)
    {
        $this->transporter->setParam('toIndex', (int) $size);

        return $this;
    }

    /**
     * Module for which you want to fetch the related records
     * i.e: If you want to fetch Notes related to a Candidate, then Candidate is your parent module.
     *
     * @param string $parentModule
     *
     * @return GetRelatedRecords
     */
    public function parentModule($parentModule)
    {
        $this->transporter->setParam('parentModule', $parentModule);

        return $this;
    }

    /**
     * The id of the record for which you want to fetch related records
     *
     * @param string $id
     *
     * @return GetRelatedRecords
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
            ->setMethod('getRelatedRecords')
            ->setParam('newFormat', 1)
            ->setParam('version', 2);
    }
}
