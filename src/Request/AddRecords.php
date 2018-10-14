<?php
namespace Apora\ZohoRecruitClient\Request;

use Apora\ZohoRecruitClient\Response\Result;

/**
 * Zoho Recruit method to insert records into the required Zoho Recruit module
 *
 * @see https://www.zoho.com/recruit/api/api-methods/addRecordsMethod.html
 */
class AddRecords extends ZohoRecruitRequest
{
    /** @var array */
    private $records = [];

    /**
     * @param array $record Record as a simple associative array
     *
     * @return AddRecords
     */
    public function addRecord(array $record)
    {
        $this->records[] = $record;

        return $this;
    }

    /**
     * @param array $records array containing records otherwise added by addRecord()
     *
     * @return AddRecords
     */
    public function setRecords(array $records)
    {
        $this->records = $records;

        return $this;
    }

    /**
     * Trigger the workflow rule while inserting records into Recruit account
     *
     * @return AddRecords
     */
    public function triggerWorkflow()
    {
        $this->transporter->setParam('wfTrigger', 'true');

        return $this;
    }

    /**
     * Check the duplicate records, if exists, update the same
     *
     * @return AddRecords
     */
    public function onDuplicateUpdate()
    {
        $this->transporter->setParam('duplicateCheck', 2);

        return $this;
    }

    /**
     * Check the duplicate records and throw an error response if exists
     *
     * @return AddRecords
     */
    public function onDuplicateError()
    {
        $this->transporter->setParam('duplicateCheck', 1);

        return $this;
    }

    /**
     * Keep the records in approval mode
     *
     * @return AddRecords
     */
    public function requireApproval()
    {
        $this->transporter->setParam('isApproval', 'true');

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
            ->setMethod('addRecords')
            ->setParam('version', 4);
    }
}
