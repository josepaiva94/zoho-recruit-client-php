<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to add a photo to a contact or candidate
 */
class UploadPhoto extends ZohoRecruitRequest
{
    /**
     * Specify the unique ID of the record.
     *
     * @param string $id
     *
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
     * @param string      $path       - this must be the full path of the file. i.e: /home/path/to/file.extension
     * @param string|null $prettyname - pretty name to use for file
     *
     * @return UploadPhoto
     */
    public function uploadFromPath($path, $prettyname = null)
    {
        $this->transporter->setParam('content', [
            'file' => true,
            'path' => $path,
            'prettyname' => isset($prettyname) ? basename($prettyname) : basename($path)
        ]);

        return $this;
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('uploadPhoto')
            ->setParam('version', 2);
    }
}
