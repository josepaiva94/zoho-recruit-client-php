<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to download the photo of a contact or candidate
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class DownloadPhoto extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('downloadPhoto')
            ->setParam('version', 2);
    }

    /**
     * Specify the unique ID of the record.
     *
     * @param string $id
     * @return DownloadPhoto
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);
        return $this;
    }

    /**
     * This must be the full path of the file. i.e: /home/path/to/file.extension
     * In this location the photo will be saved
     *
     * @param string $path
     * @return DownloadPhoto
     */
    public function setFilePath($path)
    {
        $this->transporter->setParam('file_path', $path);
        return $this;
    }
}
