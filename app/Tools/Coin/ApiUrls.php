<?php

namespace App\Tools\Coin;

class ApiUrls
{

    static function getMainCurrencies() :string
    {
        return 'https://min-api.cryptocompare.com/data/all/coinlist';
    }

    static function getExtraCurrencies() :string
    {
        return 'https://bitebtc.com/api/v1/market';
    }


    static function coinExtraPrice(Ticker $from, Ticker $to) :string
    {
        return 'https://bitebtc.com/api/v1/ticker?market=' .
            $from->getName() . '_' . $to->getName();
    }


    static function tradeReturn(string $id) :string
    {
        return 'https://api.hitbtc.com/api/2/public/symbol/' . $id;
    }


    static function coinMainMultiPrices(Ticker $ticker, array $toCoins = ['USD'])
    {
        $baseUrl = 'https://min-api.cryptocompare.com/data/price?fsym='.
            $ticker->getName() . '&tsyms=';

        foreach ($toCoins as $coinTicker)
        {
            if(substr($baseUrl, -1) != '=')$baseUrl .= ',';
            $baseUrl .= $coinTicker;
        }
        return $baseUrl;
    }
}