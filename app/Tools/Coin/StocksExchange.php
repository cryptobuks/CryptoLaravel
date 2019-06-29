<?php

namespace App\Tools\Coin;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class StocksExchange
{

    private $allCoins;

    public function __construct()
    {
        $this->allCoins = $this->getAllCoinsDB();
    }

    public function getAllCoinsDB() :array
    {
        $dbCoins = DB::table('coins')->get()->all();
        return $dbCoins;
    }

    static function uniObjectsArray($coins)
    {
        $tmp = [];
        $outCoins = [];

        foreach($coins as $coin)
        {
            $coinTickerName = $coin->getTicker()->getName();
            if (!in_array( $coinTickerName, $tmp))
            {
                $outCoins[] = $coin;
            }
            $tmp[] = $coinTickerName;
        }

        return $outCoins;
    }

    public function getAllCoinsApi() :array
    {
        $client = new Client();
        $coins = [];

        //extra
        $output = $client->request('GET', ApiUrls::getExtraCurrencies());
        $output = json_decode($output->getBody());

        foreach ($output->result as $coin)
        {
            $fromTicker = new Ticker(explode('_', $coin->market)[0]);
            $toTicker = new Ticker(explode('_', $coin->market)[1]);

            $coins[] = new Coin(
                $fromTicker,
                ApiUrls::coinExtraPrice($fromTicker, $toTicker),
                ($toTicker->getName() == 'USD') ? $coin->price : '',
                ($toTicker->getName() == 'BTC') ? $coin->price : ''
            );
        }


        //main
        $output = $client->request('GET', ApiUrls::getMainCurrencies());
        $output = json_decode($output->getBody());

        foreach ($output->Data as $coin)
        {
            $coinTicker = new Ticker($coin->Symbol);

            $coins[] = new Coin(
                $coinTicker,
                ApiUrls::coinMainMultiPrices($coinTicker, ['BTC','USD'])
            );
        }

        $coins = $this->uniObjectsArray($coins);

        return $coins;

    }

    static function getCoin(Ticker $ticker) :array
    {
        $dbCoin = DB::table('coins')
            ->where('ticker', '=', $ticker->getName())->get()->all();
        return $dbCoin;
    }


    static function coinMultiPrices(Coin $coin, array $toCoins = ['USD'])
    {
        $client = new Client();

        $output = $client->request('GET', ApiUrls::coinMultiPrices($coin, $toCoins));

        $output = json_decode($output->getBody());

        return $output;
    }

}