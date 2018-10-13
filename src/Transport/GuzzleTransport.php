<?php

namespace Apora\ZohoRecruitClient\Transport;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * Transport implemented using the Guzzle library to do HTTP calls to Zoho
 *
 * @package Apora\ZohoRecruitClient\Transport
 */
class GuzzleTransport implements Transport
{

    private $client;

    public function __construct($baseUri, $timeout)
    {
        $this->client = new Client(['base_uri' => $baseUri, 'timeout' => $timeout]);
    }

    /**
     * @param string $module    Zoho Recruit API module
     * @param string $method    Zoho Recruit API method
     * @param array  $paramList Parameters for call
     * @return string Result of the call
     * @throws HttpException if the response status code is not success
     */
    public function call($module, $method, array $paramList)
    {

        $url = $module . '/' . $method;

        $headers = array();

        // Checking for multipart request
        $multipart = false;
        foreach ($paramList as $param) {
            if (is_resource($param) && get_resource_type($param) == 'stream') {
                $multipart = true;
                break;
            }
        }

        if ($multipart) {
            $formData = array();
            foreach ($paramList as $key => $value) {
                $formData[] = array('name' => $key, 'contents' => $value);
            }
            /** @var Response $response */
            $response = $this->client->post($url, array('headers' => $headers, 'multipart' => $formData));
        } else {
            $requestData = http_build_query($paramList, '', '&');
            if ($method === 'getRecords' || $method === 'getRecordById') {
                /** @var Response $response */
                $response = $this->client->get($url . '?' . $requestData);
            } else {
                /** @var Response $response */
                $response = $this->client->post($url, array('headers' => $headers, 'form_params' => $paramList));
            }
        }

        $responseContent = $response->getBody();

        if ($response->getStatusCode() !== 200) {
            throw new HttpException($responseContent, $response->getStatusCode());
        }

        return $responseContent;
    }
}