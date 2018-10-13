<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to add a photo to a contact or candidate
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class UploadPhoto extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('uploadPhoto')
            ->setParam('version', 2);
    }

    /**
     * Specify the unique ID of the record.
     *
     * @param string $id
     * @return UploadPhoto
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);
        return $this;
    }

    /**
     * Pass the file input stream to a record
     *
     * @param string $path - this must be the full path of the file. i.e: /home/path/to/file.extension
     * @return UploadPhoto
     */
    public function uploadFromPath($path)
    {
        $this->transporter->setParam('content', fopen($path, 'r'));
        return $this;
    }
}
