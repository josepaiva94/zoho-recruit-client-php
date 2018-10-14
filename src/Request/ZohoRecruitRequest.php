<?php
namespace Apora\ZohoRecruitClient\Request;

use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;
use Apora\ZohoRecruitClient\Transport\RequestTransporter;

/**
 * Generic implementation of requests to Zoho Recruit API
 */
abstract class ZohoRecruitRequest implements Request
{
    /** @var RequestTransporter */
    protected $transporter;

    public function __construct(RequestTransporter $transporter)
    {
        $this->transporter = $transporter;
        $this->configureRequest();
    }

    /**
     * Include the empty fields in the response.
     *
     * @return ZohoRecruitRequest self
     */
    public function withEmptyFields()
    {
        $this->transporter->setParam('newFormat', 2);

        return $this;
    }

    /**
     * Exclude the empty fields from the response.
     *
     * @return ZohoRecruitRequest self
     */
    public function withoutEmptyFields()
    {
        $this->transporter->setParam('newFormat', 1);

        return $this;
    }

    /**
     * Set the API version to use
     *
     * @param int $version
     *
     * @return ZohoRecruitRequest self
     */
    public function version($version)
    {
        $this->transporter->setParam('version', $version);

        return $this;
    }

    /**
     * @return Record|Record[]|Field|Field[]|Result|Result[]|bool
     */
    public function request()
    {
        return $this->transporter->request();
    }

    /**
     * Set the method and default parameters
     */
    abstract protected function configureRequest();
}
