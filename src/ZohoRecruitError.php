<?php

namespace Apora\ZohoRecruitClient;

/**
 * Class ZohoRecruitError
 *
 * @package Apora\ZohoRecruitClient
 * @see https://www.zoho.com/recruit/api-new/error-messages.html
 */
class ZohoRecruitError
{
    public static $errorCodes = array(
        '2000' => 'Record added successfully.',
        '2001' => 'Record updated successfully.',
        '2002' => 'Record already exists.',
        '4000' => 'Please use Authtoken, instead of API ticket and APIkey.',
        '4500' => 'Internal server error while processing this request.',
        '4501' => 'API Key is inactive.',
        '4502' => 'This module is not supported in your edition.',
        '4401' => 'Mandatory field missing.',
        '4600' => 'Incorrect API parameter or API parameter value. Also check the method name and/or spelling errors in the API url.',
        '4831' => 'Missing parameters error.',
        '4832' => 'Text value given for an Integer field.',
        '4834' => 'Invalid ticket. Also check if ticket has expired.',
        '4835' => 'XML parsing error.',
        '4890' => 'Wrong API Key.',
        '4487' => 'No permission to convert lead.',
        '4001' => 'No API permission.',
        '401' => 'No module permission.',
        '401.1' => 'No permission to create a record.',
        '401.2' => 'No permission to edit a record.',
        '401.3' => 'No permission to delete a record.',
        '402.1' => 'No permission to import document.',
        '402.2' => 'No permission to associate.',
        '402.3' => 'No permission to change status.',
        '402.4' => 'No permission for add-on.',
        '4101' => 'Zoho Recruit disabled.',
        '4102' => 'No Recruit account.',
        '4103' => 'No record available with the specified record ID.',
        '4422' => 'No records available in the module.',
        '4420' => 'Wrong value for search parameter and/or search parameter value.',
        '4421' => 'Number of API calls exceeded.',
        '4807' => 'Exceeded file size limit.',
        '4424' => 'Invalid File Type.',
        '4809' => 'Exceeded storage space limit.',
        '3809' => 'Exceeded parsing document limit.',
    );

    public $code;
    public $description;

    public function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
}