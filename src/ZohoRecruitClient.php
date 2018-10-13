<?php
/**
 * This file is part of the Apora.ZohoRecruitClient
 *
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace Apora\ZohoRecruitClient;

use Apora\ZohoRecruitClient\Transport\RequestTransporter;
use Apora\ZohoRecruitClient\Transport\XMLTransportDecorator;

class ZohoRecruitClient
{
    /** @var string */
    private $module;
    /** @var Transport\Transport */
    protected $transport;

    /**
     * @param string $module
     * @param string $authToken
     * @param string $domain
     * @param int    $timeout
     */
    public function __construct($module, $authToken, $domain = 'com', $timeout = 5)
    {
        $this->module = $module;
        if ($authToken instanceof Transport\Transport) {
            $this->transport = $authToken;
        } else {
            $this->transport = new XMLTransportDecorator(
                new Transport\AuthenticationTokenTransportDecorator(
                    $authToken,
                    new Transport\GuzzleTransport(
                        'https://recruit.zoho.' . $domain . '/recruit/private/xml/',
                        $timeout
                    )
                )
            );
        }
    }

    /**
     * Sets the Zoho Recruit module, overriding the current value
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return Request\GetRecords
     */
    public function getRecords()
    {
        return new Request\GetRecords($this->request());
    }

    /**
     * @param int|null $id
     * @return Request\GetRecordById
     */
    public function getRecordById($id = null)
    {
        $request = new Request\GetRecordById($this->request());
        if ($id !== null) {
            $request->id($id);
        }
        return $request;
    }

    /**
     * @return Request\AddRecords
     */
    public function addRecords()
    {
        return new Request\AddRecords($this->request());
    }

    /**
     * @return Request\UpdateRecords
     */
    public function updateRecords()
    {
        return new Request\UpdateRecords($this->request());
    }

    /**
     * @return Request\GetNoteTypes
     */
    public function getNoteTypes()
    {
        return new Request\GetNoteTypes($this->request());
    }

    /**
     * @return Request\GetRelatedRecords
     */
    public function getRelatedRecords()
    {
        return new Request\GetRelatedRecords($this->request());
    }

    /**
     * @return Request\GetFields
     */
    public function getFields()
    {
        return new Request\GetFields($this->request());
    }

    /**
     * @return Request\GetAssociatedJobOpenings
     */
    public function getAssociatedJobOpenings()
    {
        return new Request\GetAssociatedJobOpenings($this->request());
    }

    /**
     * @return Request\ChangeStatus
     */
    public function changeStatus()
    {
        return new Request\ChangeStatus($this->request());
    }

    /**
     * @return Request\UploadFile
     */
    public function uploadFile()
    {
        return new Request\UploadFile($this->request());
    }

    /**
     * @return Request\DownloadFile
     */
    public function downloadFile()
    {
        return new Request\DownloadFile($this->request());
    }

    /**
     * @return Request\AssociateJobOpening
     */
    public function associateJobOpening()
    {
        return new Request\AssociateJobOpening($this->request());
    }

    /**
     * @return Request\UploadPhoto
     */
    public function uploadPhoto()
    {
        return new Request\UploadPhoto($this->request());
    }

    /**
     * @return Request\DownloadPhoto
     */
    public function downloadPhoto()
    {
        return new Request\DownloadPhoto($this->request());
    }

    /**
     * @return Request\UploadDocument
     */
    public function uploadDocument()
    {
        return new Request\UploadDocument($this->request());
    }

    /**
     * @return Request\GetModules
     */
    public function getModules()
    {
        return new Request\GetModules($this->request());
    }

    /**
     * @return Request\GetAssociatedCandidates
     */
    public function getAssociatedCandidates()
    {
        return new Request\GetAssociatedCandidates($this->request());
    }

    /**
     * @return Request\GetSearchRecords
     */
    public function searchRecords()
    {
        return new Request\GetSearchRecords($this->request());
    }

    /**
     * @return RequestTransporter
     */
    protected function request()
    {
        $request = new Transport\RequestTransporter($this->module);
        $request->setTransport($this->transport);
        return $request;
    }
}
