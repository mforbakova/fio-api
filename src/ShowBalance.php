<?php

namespace App;

use App\TodayDate;

class ShowBalance
{
    protected string $token;
    public string $today;
    public string $currency;

    public function __construct()
    {
    }

    public function getBalance(): string
    {
        // get content of json file
        $json = file_get_contents(GetUrl::getUrl());
        $array = json_decode($json, true);
        $amount = $array['accountStatement']['info']['closingBalance'];
        $currency = $array['accountStatement']['info']['currency'];
        $amount = number_format($amount, 2, ',', ' ');

        $todayNice = TodayDate::getDate();

        return "Na účte máte k dňu " . $todayNice . " 
                zostatok <strong>" . $amount . "</strong> " . $currency . ".";
    }
}
