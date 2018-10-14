<?php
namespace Apora\ZohoRecruitClient\Request;

use Apora\ZohoRecruitClient\Response\Result;

/**
 * Zoho Recruit method to update or modify the records in Zoho Recruit
 */
class UpdateRecords extends ZohoRecruitRequest
{
    /** @var array */
    private $records = [];

    /**
     * @param array $record Record as a simple associative array
     *
     * @return UpdateRecords
     */
    public function addRecord(array $record)
    {
        $this->records[] = $record;

        return $this;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     *
     * @return UpdateRecords
     */
    public function setRecords(array $records)
    {
        $this->records = $records;

        return $this;
    }

    /**
     * ID of the record
     *
     * @param string $id
     *
     * @return UpdateRecords
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);

        return $this;
    }

    /**
     * Trigger the workflow rule while inserting records into Recruit account
     *
     * @return UpdateRecords
     */
    public function triggerWorkflow()
    {
        $this->transporter->setParam('wfTrigger', 'true');

        return $this;
    }

    /**
     * @return Result[]
     */
    public function request()
    {
        return $this->transporter
            ->setParam('xmlData', $this->records)
            ->request();
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('updateRecords')
            ->setParam('version', 4);
    }
}
