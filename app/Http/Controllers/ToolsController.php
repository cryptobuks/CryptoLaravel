<?php


namespace App\Http\Controllers;

use App\Tools\Coin\ApiUrls;
use App\Tools\Coin\StocksExchange;
use App\Tools\Coin\Ticker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Tools\Coin\Coin;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    /***
     * @param StocksExchange $stocksExchange
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coinsPage(StocksExchange $stocksExchange)
    {
        $dbCoins = DB::table('coins')->get()->all();

        return view('coins/coins', ['coins' => $dbCoins]);
    }

    public function coin(string $ticker, Request $request)
    {
        $fromTicker = new Ticker($ticker);
        $toTicker = new Ticker('BTC');

        $coin = new Coin($fromTicker);
        $toCoin = new Coin($toTicker);

        if (!$coin->isValid())
        {
            $request->session()->flash('message.level', 'danger');
            $request->session()->flash(
                'message.content', $ticker . ' is not supported or is invalid!'
            );
            return view('error');
        }

        return view('coins/coin' , [
                'fromCoin' => $coin,
                'toCoin' => $toCoin,
                'isMain' => $coin->isMain(),
                'otherCoins' => array_diff(['WEB', 'BTC', 'ETH', 'XMR'],
                    [$fromTicker->getName()]),
            ]
        );
    }
}
