<?php

namespace App;

use App\GetXML;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Exception;

class SendMoney
{
    public string $client;
    private string $uploadUrl;

    public function __construct()
    {
    }

    public function sendMoney($accountFrom, $accountTo, $number): void
    {
        $arrayFrom = explode("/", $accountFrom);
        $accountFrom = $arrayFrom[0];
        $arrayTo = explode("/", $accountTo);
        $accountTo = $arrayTo[0];
        $bankCode = $arrayTo[1];

        $number = number_format($number, 2, '.', '');

        $xml = new GetXML();
        $xml->setTodayDate();
        $xml->setAmount($number);
        $xml->setBankAccountFrom($accountFrom);
        $xml->setBankAccountTo($accountTo);
        $xml->setBankCode($bankCode);
        // $xml->setBankCode($code);

        $uploadUrl = 'https://www.fio.cz/ib_api/rest/import/';

        $client = new Client(
            [
                // Base URI is used with relative requests
                'base_uri' => $uploadUrl,
                // You can set any number of default request options.
                'timeout'  => 2.0,
            ]
        );

        $token = $_ENV['APP_STRONG_TOKEN'];

        // sends multipart form data to bank url
        $response = $client->request(
            'POST',
            $uploadUrl,
            ['multipart' =>
                [
                    [
                        'name' => 'token',
                        'contents' => $token,
                    ],
                    [
                        'name' => 'type',
                        'contents' => 'xml'
                    ],
                    [
                        'name' => 'file',
                        'filename' => 'file.xml',
                        'contents' => $xml->getXmlAsString()
                    ]
                ]
            ]
        );

        // var_dump($client->http_response_code('POST'));

        $responseXml = simplexml_load_string((string) $response->getBody());

        $status = (string) $responseXml->result->status;
        if ($status === 'error') {
            throw new Exception((string) $responseXml->result->message);
        }
    }
}
