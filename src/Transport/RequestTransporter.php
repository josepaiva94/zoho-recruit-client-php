<?php
namespace Apora\ZohoRecruitClient\Transport;

use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;

/**
 * Model representing the request to Zoho without the sugar
 */
class RequestTransporter
{
    /** @var Transport */
    private $transport;
    /** @var string */
    private $module;
    /** @var string */
    private $method;
    /** @var array */
    private $paramList;

    /**
     * @param string $module
     */
    public function __construct($module)
    {
        $this->module = $module;
        $this->paramList = [];
    }

    /**
     * @param Transport $transport
     *
     * @return RequestTransporter self
     */
    public function setTransport(Transport $transport)
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @return Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param string $method
     *
     * @return RequestTransporter
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return RequestTransporter
     */
    public function setParam($key, $value)
    {
        if ($value === null) {
            unset($this->paramList[$key]);
        } else {
            $this->paramList[$key] = $value;
        }

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function getParam($key)
    {
        return array_key_exists($key, $this->paramList) ? $this->paramList[$key] : null;
    }

    /**
     * @return Record[]|Field|Result|Result[]|bool
     */
    public function request()
    {
        return $this->transport->call(
            $this->module,
            $this->method,
            $this->paramList
        );
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }
}
