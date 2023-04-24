<?php

namespace App;

use App\TodayDate;

class GetUrl
{
    public string $url;

    private function __construct()
    {
    }

    public static function getUrl(): string
    {
        $_today = TodayDate::getToday()->format('Y-m-d');
        $url = "https://www.fio.cz/ib_api/rest/periods/" . $_ENV['APP_TOKEN'] .
                "/" . $_today . "/" . $_today . "/transactions.json";

        return $url;
    }
}
