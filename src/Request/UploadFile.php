<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to attach a file to a record
 */
class UploadFile extends ZohoRecruitRequest
{
    /**
     * Specify the unique ID of the record to which the file has to be attached.
     *
     * @param string $id
     *
     * @return UploadFile
     */
    public function id($id)
    {
        $this->transporter->setParam('id', $id);

        return $this;
    }

    /**
     * Specify the attachment type (E.g. Resume or Others).
     *
     * @param string $type
     *
     * @return UploadFile
     */
    public function type($type)
    {
        $this->transporter->setParam('type', $type);

        return $this;
    }

    /**
     * Pass the file input stream to a record
     *
     * @param string $path - this must be the full path of the file. i.e: /home/path/to/file.extension
     *
     * @return UploadFile
     */
    public function uploadFromPath($path)
    {
        $this->transporter->setParam('content', fopen($path, 'r'));

        return $this;
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('uploadFile')
            ->setParam('version', 2);
    }
}
