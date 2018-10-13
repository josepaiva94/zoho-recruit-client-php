<?php

namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to download a file attached to a record
 *
 * @package Apora\ZohoRecruitClient\Request
 */
class DownloadFile extends ZohoRecruitRequest
{

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('downloadFile')
            ->setParam('version', 2);
    }

    /**
     * Set the file id to download
     *
     * @param string $id
     * @return DownloadFile
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);
        return $this;
    }

    /**
     * This must be the full path of the file. i.e: /home/path/to/file.extension
     * In this location the file will be saved
     *
     * @param string $path
     * @return DownloadFile
     */
    public function setFilePath($path)
    {
        $this->transporter->setParam('file_path', $path);
        return $this;
    }
}
