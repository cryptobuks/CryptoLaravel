<?php

namespace App\Tools\Coin;

class Utils
{

    public static function getTickers() :array
    {
        return StocksExchange::getCurrenciesTickers();
    }

    public function getOtherTickers(Ticker $exceptTicker)
    {
        return array_diff(
            self::getTickers(), [$exceptTicker]
        );
    }

}