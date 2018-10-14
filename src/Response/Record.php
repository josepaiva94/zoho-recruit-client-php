<?php
namespace Apora\ZohoRecruitClient\Response;

/**
 * Response to API listing/get methods will be a set of Record
 */
class Record
{
    /** @var int|null */
    public $index;
    /** @var array */
    public $data;

    /**
     * @param array $data
     * @param int   $index
     */
    public function __construct(array $data, $index = null)
    {
        $this->index = $index;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_key_exists($key, $this->data) ? $this->data[$key] : $default;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Parse the record to JSON string
     *
     * @return string
     */
    public function toJSON()
    {
        return json_encode($this->data);
    }
}
