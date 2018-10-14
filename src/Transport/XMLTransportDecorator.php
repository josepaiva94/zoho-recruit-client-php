<?php
namespace Apora\ZohoRecruitClient\Transport;

use Apora\ZohoRecruitClient\Exception\Exception;
use Apora\ZohoRecruitClient\Exception\NoDataException;
use Apora\ZohoRecruitClient\Exception\RuntimeException;
use Apora\ZohoRecruitClient\Exception\UnexpectedValueException;
use Apora\ZohoRecruitClient\Exception\ZohoRecruitErrorException;
use Apora\ZohoRecruitClient\Response\Field;
use Apora\ZohoRecruitClient\Response\Record;
use Apora\ZohoRecruitClient\Response\Result;
use Apora\ZohoRecruitClient\ZohoRecruitError;
use SimpleXMLElement;

/**
 * Transport decorator that handles XML communication with Zoho Recruit
 */
class XMLTransportDecorator extends TransportDecorator
{
    /** @var string */
    private $module;
    /** @var string */
    private $method;
    /** @var array */
    private $call_params;

    /**
     * @param Transport $transport to be decorated with XML support
     */
    public function __construct(Transport $transport)
    {
        parent::__construct($transport);
    }

    /**
     * @param string $module    Zoho Recruit API module
     * @param string $method    Zoho Recruit API method
     * @param array  $paramList Parameters for call
     *
     * @throws Exception if an error occurs while parsing the response body returned by Zoho
     *
     * @return Record|Record[]|Field|Field[]|Result|Result[]|bool Result of the call
     */
    public function call($module, $method, array $paramList)
    {
        $this->module = $module;
        $this->method = $method;
        $this->call_params = $paramList;

        if (array_key_exists('xmlData', $paramList)) {
            $paramList['xmlData'] = $this->encodeRecords($paramList['xmlData']);
        }

        $response = $this->transport->call($module, $method, $paramList);

        return $this->parse($response);
    }

    /**
     * @param array $records
     *
     * @throws RuntimeException
     *
     * @return string XML representation of the records
     */
    private function encodeRecords(array $records)
    {
        $module = $this->method == 'updateRelatedRecords' ?
            $this->call_params['relatedModule'] : $this->module;

        $root = new SimpleXMLElement('<' . $module . '></' . $module . '>');

        foreach ($records as $no => $record) {
            $row = $root->addChild('row');
            $row->addAttribute('no', $no + 1);
            $this->encodeRecord($record, 'FL', $row);
        }

        return $root->asXML();
    }

    /**
     * Encodes a request record
     *
     * @param array            $record
     * @param string           $childName XML node name
     * @param SimpleXMLElement $xml
     */
    private function encodeRecord($record, $childName, &$xml)
    {
        foreach ($record as $key => $value) {
            if ($value instanceof \DateTime) {
                if ($value->format('His') === '000000') {
                    $value = $value->format('m/d/Y');
                } else {
                    $value = $value->format('Y-m-d H:i:s');
                }
            }
            $keyValue = $xml->addChild($childName);
            $keyValue->addAttribute('val', $key);
            if (is_array($value)) {
                $this->parseNestedValues($value, $keyValue);
            } else {
                $keyValue[0] = $value;
            }
        }
    }

    /**
     * @param array            $array
     * @param SimpleXMLElement $xml
     */
    private function parseNestedValues($array, &$xml)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $type = $value['@type'] ?? 'null';
                unset($value['@type']);
                $subNode = $xml->addChild("$type");
                $subNode->addAttribute('no', $key + 1);
                $this->parseNestedValues($value, $subNode);
            } else {
                $keyValue = $xml->addChild('FL');
                $keyValue[0] = $value;
                $keyValue->addAttribute('val', $key);
            }
        }
    }

    /**
     * Parses the XML returned by Zoho to the appropriate objects
     *
     * @param string $content Response body as returned by Zoho
     *
     * @throws UnexpectedValueException  if invalid XML is given to parse
     * @throws NoDataException           if Zoho tells us there is no data
     * @throws ZohoRecruitErrorException if content is an error response
     * @throws Exception                 if an error occurs while parsing the response body returned by Zoho
     *
     * @return bool|Record|Record[]|Field[]|Result|Result[]
     */
    private function parse($content)
    {
        if ($this->method == 'downloadFile' || $this->method == 'downloadPhoto') {
            return $this->parseResponseDownload($content);
        }

        $xml = new SimpleXMLElement($content);
        if (isset($xml->error)) {
            throw new ZohoRecruitErrorException(
                new ZohoRecruitError(
                    (string) $xml->error->code,
                    (string) $xml->error->message
                )
            );
        }

        if (isset($xml->nodata)) {
            throw new NoDataException(
                new ZohoRecruitError(
                    (string) $xml->nodata->code,
                    (string) $xml->nodata->message
                )
            );
        }

        if ($this->method == 'getFields') {
            return $this->parseResponseGetFields($xml);
        }

        if (strncmp($this->method, 'upload', strlen('upload')) === 0) {
            return $this->parseResponseMutateRecord($xml, 'upload');
        }

        if ($this->method === 'changeStatus' || $this->method === 'associateJobOpening') {
            return $this->parseResponseMutateRecord($xml);
        }

        if (isset($xml->result->{$this->module})) {
            return $this->parseResponseFetchRecords($xml);
        }

        if (isset($xml->result->row->success) || isset($xml->result->row->error)) {
            return $this->parseResponseAddUpdateMultipleRecords($xml);
        }

        throw new UnexpectedValueException('XML doesn\'t contain expected fields');
    }

    /**
     * Parses a response to a download Zoho Recruit API call
     *
     * @param string $file_content
     *
     * @throws Exception
     *
     * @return bool
     */
    private function parseResponseDownload($file_content)
    {
        if (! isset($this->call_params['file_path'])) {
            throw new Exception('Missed file path, set it');
        }

        $fp = fopen($this->call_params['file_path'], 'w');
        $success = fwrite($fp, $file_content);
        fclose($fp);

        return $success ? true : false;
    }

    /**
     * Parses a response to the getFields() Zoho Recruit API call
     *
     * @param SimpleXMLElement $xml
     *
     * @return array
     */
    private function parseResponseGetFields($xml)
    {
        $records = [];
        foreach ($xml->section as $section) {
            foreach ($section as $field) {
                $options = [];
                if ($field->children()->count() > 0) {
                    $options = [];
                    foreach ($field->children() as $value) {
                        $options[] = (string) $value;
                    }
                }

                $records[] = new Field(
                    (string) $section['name'],
                    (string) $field['label'],
                    (string) $field['type'],
                    (string) $field['req'] === 'true',
                    (string) $field['isreadonly'] === 'true',
                    (int) $field['maxlength'],
                    $options,
                    (string) $field['customfield'] === 'true'
                );
            }
        }

        return $records;
    }

    /**
     * Parses a response to Zoho Recruit API calls to fetch records
     *
     * @param SimpleXMLElement $xml
     *
     * @return array
     */
    private function parseResponseFetchRecords(SimpleXMLElement $xml)
    {
        $records = [];
        foreach ($xml->result->{$this->module}->row as $row) {
            $records[(string) $row['no']] = $this->parseRowToRecord($row);
        }

        return $records;
    }

    /**
     * Parses a response to Zoho Recruit API calls that add/update records in batch
     *
     * @param SimpleXMLElement $xml
     *
     * @return array
     */
    private function parseResponseAddUpdateMultipleRecords($xml)
    {
        $records = [];
        foreach ($xml->result->row as $row) {
            $no = (string) $row['no'];
            if (isset($row->success)) {
                $success = new Result((int) $no, (string) $row->success->code);
                $data = [];
                foreach ($row->success->details->children() as $field) {
                    $data[(string) $field['val']] = (string) $field;
                }
                $records[$no] = $success->setData($data);
            } else {
                $error = new Result((int) $no, (string) $row->error->code);
                $error->setError(
                    new ZohoRecruitError((string) $row->error->code, (string) $row->error->details)
                );
                $records[$no] = $error;
            }
        }

        return $records;
    }

    /**
     * Parse a response to Zoho Recruit API calls that mutate (except add/update) a record
     *
     * @param SimpleXMLElement $xml
     * @param string           $type
     *
     * @return Result
     */
    private function parseResponseMutateRecord($xml, $type = 'mutate')
    {
        $code = '0';
        if (isset($xml->result->recorddetail)) {
            if ($type === 'mutate') {
                $code = '2001';
            } elseif ($type === 'upload') {
                $code = '4800';
            }
        }

        $response = new Result(1, $code);

        if ($code !== '0') {
            $data = [];
            foreach ($xml->result->recorddetail as $field) {
                if ($field->count() > 0) {
                    foreach ($field->children() as $item) {
                        foreach ($item->children() as $subitem) {
                            $data[(string) $field['val']][(string) $item['no']][(string) $subitem['val']] = (string) $subitem;
                        }
                    }
                } else {
                    $data[(string) $field['val']] = (string) $field;
                }
            }

            $response->setData($data);
        }

        return $response;
    }

    /* Helper methods */

    /**
     * Parses a row XML element into a Record
     *
     * @param SimpleXMLElement $row
     *
     * @return Record
     */
    private function parseRowToRecord($row)
    {
        $data = [];
        foreach ($row as $field) {
            if ($field->count() > 0) {
                foreach ($field->children() as $item) {
                    foreach ($item->children() as $subitem) {
                        $data[(string) $field['val']][(string) $item['no']][(string) $subitem['val']] = (string) $subitem;
                    }
                }
            } else {
                $data[(string) $field['val']] = (string) $field;
            }
        }

        return new Record($data, (int) $row['no']);
    }
}
