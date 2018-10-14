<?php
namespace Apora\ZohoRecruitClient\Request;

/**
 * Zoho Recruit method to parse and upload candidate resumes from third-party applications
 */
class UploadDocument extends ZohoRecruitRequest
{
    /**
     * Specify the base64 encoded string of the document to be uploaded.
     *
     * @param string $data
     *
     * @return UploadDocument
     */
    public function documentData($data)
    {
        $this->transporter->setParam('documentData', $data);

        return $this;
    }

    /**
     * Specify the file name and the file format.
     *
     * @param string $fileName
     *
     * @return UploadDocument
     */
    public function fileName($fileName)
    {
        $this->transporter->setParam('fileName', $fileName);

        return $this;
    }

    /**
     * Specify the country. Values allowed AR|AU|BE|CZ|FR|DE|GR|HU|IN|IE|IT|NL|NO|RU|ZA|ES|SE|GB|USA
     *
     * @param string $country
     *
     * @return UploadDocument
     */
    public function country($country)
    {
        $this->transporter->setParam('country', $country);

        return $this;
    }

    /**
     * Specify the source.
     *
     * @param string $source
     *
     * @return UploadDocument
     */
    public function source($source)
    {
        $this->transporter->setParam('source', $source);

        return $this;
    }

    /**
     * Set the method and default parameters
     */
    protected function configureRequest()
    {
        $this->transporter
            ->setMethod('uploadDocument')
            ->setParam('version', 2);
    }
}
