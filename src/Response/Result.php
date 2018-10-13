<?php

namespace Apora\ZohoRecruitClient\Response;

use DateTime;

use Apora\ZohoRecruitClient\ZohoRecruitError;

/**
 * Response to API insert/update methods
 *
 * @package Apora\ZohoRecruitClient\Response
 */
class Result
{
    /** @var ZohoRecruitError */
    public $error;
    /** @var int */
    public $index;
    /** @var string */
    public $code;
    /** @var array */
    public $data;

    /**
     * @param int    $index
     * @param string $code
     */
    public function __construct($index, $code)
    {
        $this->index = $index;
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return bool
     */
    public function isInserted()
    {
        return $this->code == '2000';
    }

    /**
     * @return bool
     */
    public function isUpdated()
    {
        return $this->code == '2001';
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return $this->code == '2002';
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->code == '5000' || $this->code == "4800";
    }

    /**
     * @return bool
     */
    public function isUploaded()
    {
        return $this->code === '4800';
    }

    /**
     * @return ZohoRecruitError|null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param ZohoRecruitError $error
     * @return Result
     */
    public function setError(ZohoRecruitError $error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return bool
     */
    public function isError()
    {
        return $this->error instanceof ZohoRecruitError;
    }

    /**
     * @param string $key
     * @param mixed  $default
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
     * @param array $data
     * @return Result
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
}