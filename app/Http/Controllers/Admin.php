<?php

namespace App\Http\Controllers;

use App\Tools\Coin\ApiUrls;
use App\Tools\Coin\StocksExchange;
use App\Tools\Coin\Ticker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Tools\Coin\Coin;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;


class Admin extends Controller
{

    private function isAdmin() :bool
    {
        return (Auth::user()->admin == 1);
    }

    /**
     * Show the admin page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!$this->isAdmin()) return redirect('/');

        $coinsCounter = DB::table('coins')->count();
        $dbCoins = DB::table('coins')->get()->all();
        $users = DB::table('users')
            ->orderBy('last_login_date', 'desc')->get()->all();


        return view('admin', [
            'coins' => $dbCoins,
            'users' => $users,
            'coinsCounter' => $coinsCounter,
        ]);
    }

    private function addCoin(Coin $coin)
    {
        DB::table('coins')->insert([
            'ticker' => $coin->getTicker()->getName(),
            'apiUrl' => $coin->getApiUrl(),
            'priceInUSD' => floatval($coin->getPriceInUSD()),
            'priceInBTC' => floatval($coin->getPriceInBTC()),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    private function updateCoin(Coin $coin)
    {
        DB::table('coins')
            ->where('ticker', $coin->getTicker()->getName())
            ->update([
                'apiUrl' => $coin->getApiUrl(),
                'priceInUSD' => floatval($coin->getPriceInUSD()),
                'priceInBTC' => floatval($coin->getPriceInBTC()),
                'updated_at' => Carbon::now()->toDateTimeString()
            ]);
    }

    public function AddCoins(StocksExchange $stocksExchange)
    {
        if (!$this->isAdmin()) return redirect('/');

        $coins = $stocksExchange->getAllCoinsApi();

        foreach ($coins as $coin)
        {
            if ($coin->isExistedInDB())continue;

            $this->addCoin($coin);
        }

        return redirect(route('adminPage'));
    }

    public function updateCoins(StocksExchange $stocksExchange)
    {
        if (!$this->isAdmin()) return redirect('/');

        $coins = $stocksExchange->getAllCoinsApi();

        foreach ($coins as $coin)
        {
            if (!$coin->isExistedInDB())
            {
                $this->addCoin($coin);
                continue;
            }
            $this->updateCoin($coin);
        }

        return redirect(route('adminPage'));
    }

    public function deleteCoins()
    {
        if (!$this->isAdmin()) return redirect('/');

        DB::table('coins')->truncate();

        return redirect(route('adminPage'));
    }
}