<?php

namespace App\Http\Controllers;


use App\Tools\Coin\Ticker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tools\Coin\Coin;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {

    }

    /***
     * @param string $coin
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function coin(string $ticker, Request $request)
    {
        $ticker = new Ticker($ticker);
        $coin = new Coin($ticker);

        if (!$coin->isValid())
        {
            $output = json_encode([
                "Status" => 'error',
                "Message" => 'Wrong coin or coin is not listed yet!',
            ], true);
            return view('api', ['data' => $output]);
        }

        $output = json_encode([
            'Status' => 'success',
            "Ticker" => strtolower($coin->getTicker()->getName()),
            "USD" => $coin->getPriceInUSD(),
            "BTC" => $coin->getPriceInBTC(),
        ], true);


        return view('api', ['data' => $output]);
    }




}
