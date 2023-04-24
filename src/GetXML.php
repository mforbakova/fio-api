<?php

namespace App;

use Exception;
use SimpleXMLElement;

class GetXML
{
    private SimpleXMLElement $xml;
    protected string $xpath = '/Import/Orders/DomesticTransaction';

    public function __construct()
    {
        if (!file_exists('assets/platba.xml')) {
            throw new Exception('Payment XML not exists');
        }

        $this->xml = simplexml_load_file('assets/platba.xml');
    }

    public function getXmlAsString(): mixed
    {
        return $this->xml->asXML();
    }

    public function setAmount($number): void
    {
        $this->xml->xpath($this->xpath . '/amount')[0][0] = $number;
    }

    public function setTodayDate(): void
    {
        $this->xml->xpath($this->xpath . '/date')[0][0] = date('Y-m-d');
    }

    public function setBankAccountFrom($accountFrom): void
    {
        $this->xml->xpath($this->xpath . '/accountFrom')[0][0] = $accountFrom;
    }

    public function setBankAccountTo($accountTo): void
    {
        $this->xml->xpath($this->xpath . '/accountTo')[0][0] = $accountTo;
    }

    public function setBankCode($bankCode): void
    {
        $this->xml->xpath($this->xpath . '/bankCode')[0][0] = $bankCode;
    }
}
