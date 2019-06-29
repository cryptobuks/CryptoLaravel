<?php

namespace App\Tools\Coin;

use \GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use function PHPSTORM_META\type;

class Coin
{
    private $ticker;
    private $apiUrl;
    private $priceInUSD;
    private $priceInBTC;

    public function __construct(
        Ticker $ticker,
        string $apiUrl = '',
        string $priceInUSD = '',
        string $priceInBTC = '')
    {
        $this->ticker = $ticker;
        $this->apiUrl = $apiUrl;
        $this->priceInUSD = $priceInUSD;
        $this->priceInBTC = $priceInBTC;
    }



    public function getTicker() :Ticker { return $this->ticker; }
    public function getApiUrl() :string { return $this->apiUrl; }

    public function isMain() :bool
    {
        $dbFromCoin = DB::table('coins')
            ->where('ticker', '=', $this->getTicker()->getName())
            ->get()->first();

        return ($dbFromCoin->apiUrl == ApiUrls::coinMainMultiPrices($this->getTicker(),
                ['BTC','USD']));
    }


    public function getPriceInUSD() :string
    {
        if ($this->priceInUSD != null) return $this->priceInUSD;

        if (!$this->isValid())return -1;

        $client = new Client();


        if ($this->isMain())
        {
            $output = $client->request('GET', ApiUrls::coinMainMultiPrices($this->getTicker(),
                ['USD', 'BTC']));
            $output = json_decode($output->getBody());

            $this->priceInUSD = number_format($output->USD, 10);
            $this->priceInBTC = number_format($output->BTC, 10);
            return $this->priceInUSD;
        }

        $coinBTC = new Coin(new Ticker('BTC'));
        $outputBTC = $client->request('GET', ApiUrls::coinMainMultiPrices
        ($coinBTC->getTicker()));
        $outputBTC = json_decode($outputBTC->getBody());
        $outputBTC = $outputBTC->USD;

        $output = $client
            ->request('GET', ApiUrls::coinExtraPrice($this->getTicker(),
                new Ticker('BTC'))
            );

        $output = json_decode($output->getBody());


        $priceBTC = ($this->getTicker()->getName() == 'BTC' ? 1 : $output->result->price);

        $this->priceInUSD = number_format(($priceBTC * $outputBTC), 10);
        $this->priceInBTC = number_format($priceBTC, 10);
        return $this->priceInUSD;
    }

    public function getPriceInBTC() :string
    {
        if ($this->priceInBTC != null) return $this->priceInBTC;

        if (!$this->isValid())return -1;

        $client = new Client();

        if ($this->isMain())
        {
            $output = $client->request('GET', ApiUrls::coinMainMultiPrices($this->getTicker(),
                ['USD', 'BTC']));
            $output = json_decode($output->getBody());
            $this->priceInUSD = number_format($output->USD, 10);
            $this->priceInBTC = number_format($output->BTC, 10);
            return $this->priceInBTC;
        }

        $output = $client
            ->request('GET', ApiUrls::coinExtraPrice($this->getTicker(),
                new Ticker('BTC'))
            );

        $output = json_decode($output->getBody());

        $priceBTC = ($this->getTicker()->getName() == 'BTC' ? 1 :
            $output->result->price);

        $this->priceInBTC = $priceBTC;
        return $this->priceInBTC;
    }


    public function isExistedInDB() :bool
    {
        $ticker = DB::table('coins')
            ->where('ticker', '=', $this->getTicker()->getName())->first();

        return $ticker != null;
    }

    public function isValid() :bool
    {
        $ticker = DB::table('coins')
            ->where('ticker', '=', $this->getTicker()->getName())->first();

        return $ticker != null;
    }

}