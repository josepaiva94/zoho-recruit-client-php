<?php
namespace Apora\ZohoRecruitClient\Request;

use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;

/**
 * Zoho Recruit method to search records by the expressions of the selected columns
 */
class GetSearchRecords extends ZohoRecruitRequest
{
    private $criteria = '';

    /**
     * Column names to select i.e, ['Last Name', 'Website', 'Email']
     * When not set defaults to all columns
     *
     * @param array $columns
     *
     * @return GetSearchRecords
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
     * @return GetSearchRecords
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
     * @return GetSearchRecords
     */
    public function pageSize($size)
    {
        $this->transporter->setParam('toIndex', $size);

        return $this;
    }

    /**
     * AND criteria
     *
     * @param string $field
     * @param string $op          is OR =, isn't OR <>, contains(*srcString*), starts with(srcString*), ends with(*srcString),
     *                            doesn't contain, < OR is before, > OR is after, <=, =>
     * @param string $value
     * @param bool   $wrap_before
     *
     * @return GetSearchRecords
     */
    public function where($field, $op, $value, $wrap_before = false)
    {
        if ($wrap_before && strlen($this->criteria) > 0) {
            $this->criteria = '(' . $this->criteria . ')';
        } elseif (strlen($this->criteria) > 0) {
            $this->criteria .= 'AND(' . $field . '|' . $op . '|' . $value . ')';
        } else {
            $this->criteria .= '(' . $field . '|' . $op . '|' . $value . ')';
        }

        return $this;
    }

    /**
     * OR criteria
     *
     * @param string $field
     * @param string $op          is OR =, isn't OR <>, contains(*srcString*), starts with(srcString*), ends with(*srcString),
     *                            doesn't contain, < OR is before, > OR is after, <=, =>
     * @param string $value
     * @param bool   $wrap_before
     *
     * @return GetSearchRecords
     */
    public function orWhere($field, $op, $value, $wrap_before = false)
    {
        if ($wrap_before && strlen($this->criteria) > 0) {
            $this->criteria = '(' . $this->criteria . ')';
        } elseif (strlen($this->criteria) > 0) {
            $this->criteria .= 'OR(' . $field . '|' . $op . '|' . $value . ')';
        } else {
            $this->criteria .= '(' . $field . '|' . $op . '|' . $value . ')';
        }

        return $this;
    }

    /**
     * @return Record|Record[]|Field|Field[]|Result|Result[]|bool
     */
    public function request()
    {
        return $this->transporter
            ->setParam('searchCondition', $this->criteria)
            ->request();
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('getSearchRecords')
            ->setParam('selectColumns', 'All')
            ->setParam('newFormat', 1)
            ->setParam('version', 2);
    }
}
