<?php
namespace Apora\ZohoRecruitClient\Exception;

use Apora\ZohoRecruitClient\ZohoRecruitError;

/**
 * Exception thrown due to a Zoho Recruit error
 */
class ZohoRecruitErrorException extends Exception
{
    /** @var ZohoRecruitError */
    private $error;

    public function __construct(ZohoRecruitError $error)
    {
        $this->error = $error;
        parent::__construct($error->getDescription());
    }

    /**
     * @return ZohoRecruitError
     */
    public function getError()
    {
        return $this->error;
    }
}
