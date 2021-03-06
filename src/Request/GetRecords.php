<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to retrieve all users data specified in the API request
 *
 * @see https://www.zoho.com/recruit/api/api-methods/getRecordsMethod.html
 */
class GetRecords extends ZohoRecruitRequest
{
    /**
     * Column names to select e.g., ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array|string $columns
     *
     * @return GetRecords
     */
    public function selectColumns($columns)
    {
        if (! is_array($columns)) {
            $columns = func_get_args();
        }
        $this->transporter->setParam(
            'selectColumns',
            $this->transporter->getModule() . '(' . implode(',', $columns) . ')'
        );

        return $this;
    }

    /**
     * Set the offset index of the first record (for pagination)
     *
     * @param int $index
     *
     * @return GetRecords
     */
    public function fromIndex($index)
    {
        $this->transporter->setParam('fromIndex', $index);

        return $this;
    }

    /**
     * Set the page size
     *
     * @param int $size
     *
     * @return GetRecords
     */
    public function pageSize($size)
    {
        $this->transporter->setParam('toIndex', $size);

        return $this;
    }

    /**
     * @param string $column
     *
     * @return GetRecords
     */
    public function sortBy($column)
    {
        $this->transporter->setParam('sortColumnString', $column);

        return $this;
    }

    /**
     * Sort records ascending
     *
     * @return GetRecords
     */
    public function sortAsc()
    {
        $this->sortOrder('asc');

        return $this;
    }

    /**
     * Sort records descending
     *
     * @return GetRecords
     */
    public function sortDesc()
    {
        $this->sortOrder('desc');

        return $this;
    }

    /**
     * If you specify the time, modified data will be fetched after the configured time.
     *
     * @param \DateTime $timestamp
     *
     * @return GetRecords
     */
    public function since(\DateTime $timestamp)
    {
        $this->transporter->setParam('lastModifiedTime', $timestamp->format('Y-m-d H:i:s'));

        return $this;
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getRecords')
            ->setParam('selectColumns', 'All')
            ->setParam('newFormat', 1)
            ->setParam('version', 2);
    }

    /**
     * Set the sort direction
     *
     * @param string $direction
     */
    private function sortOrder($direction)
    {
        $this->transporter->setParam('sortOrderString', $direction);
    }
}
