<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve individual records by record ID
 *
 * @see https://www.zoho.com/recruit/api/api-methods/getRecordByIdMethod.html
 * @package Apora\ZohoRecruitClient\Request
 */
class GetRecordById extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getRecordById')
            ->setParam('selectColumns', 'All')
            ->setParam('newFormat', 1)
            ->setParam('version', 2);
    }

    /**
     * Column names to select e.g., ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array|string $columns
     * @return GetRecordById
     */
    public function selectColumns($columns)
    {
        if (!is_array($columns)) {
            $columns = func_get_args();
        }
        $this->transporter->setParam(
            'selectColumns',
            $this->transporter->getModule() . '(' . implode(',', $columns) . ')'
        );
        return $this;
    }

    /**
     * ID of the record
     *
     * @param string $id
     * @return GetRecordById
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);
        return $this;
    }

    /**
     * Include Job Detail URL and Job Apply URL? This is specific to Job Openings
     *
     * Note: Job URLs appear only when the job is published in Publish in Website.
     *
     * @param bool $publishURL true to get the Job Detail URL and Job Apply URL. By default, this value is false.
     * @return GetRecordById
     */
    public function publishURL($publishURL)
    {
        $this->transporter->setParam('publishURL', $publishURL);
        return $this;
    }
}
