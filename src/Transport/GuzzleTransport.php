<?php
namespace Apora\ZohoRecruitClient\Transport;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

/**
 * Transport implemented using the Guzzle library to do HTTP calls to Zoho
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
     *
     * @throws HTTPException if the response status code is not success
     *
     * @return string Result of the call
     */
    public function call($module, $method, array $paramList)
    {
        $url = $module . '/' . $method;

        $headers = [];

        // Checking for multipart request
        $multipart = false;
        foreach ($paramList as $param) {
            if (is_array($param) && isset($param['file']) && $param['file']) {
                print_r($param);
                $multipart = true;
                break;
            }
        }

        if ($multipart) {
            $formData = [];
            foreach ($paramList as $key => $value) {
                if (is_array($value) && isset($value['file']) && $value['file']) {
                    $formData[] = ['name' => $key, 'contents' => fopen($value['path'], 'r'), 'filename' => $value['prettyname']];
                } else {
                    $formData[] = ['name' => $key, 'contents' => $value];
                }
            }
            /** @var Response $response */
            $response = $this->client->post($url, ['headers' => $headers, 'multipart' => $formData]);
        } else {
            $requestData = http_build_query($paramList, '', '&');
            if ($method === 'getRecords' || $method === 'getRecordById') {
                /** @var Response $response */
                $response = $this->client->get($url . '?' . $requestData);
            } else {
                /** @var Response $response */
                $response = $this->client->post($url, ['headers' => $headers, 'form_params' => $paramList]);
            }
        }

        $responseContent = $response->getBody();

        if ($response->getStatusCode() !== 200) {
            throw new HTTPException($responseContent, $response->getStatusCode());
        }

        return $responseContent;
    }
}
