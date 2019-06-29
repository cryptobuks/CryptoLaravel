<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class Coin
{
    private $ticker_name;
    private $price;


    public function __construct($ticker_name)
    {
        $this->ticker_name = $ticker_name;
    }

    public function getUsername(): string {return $this->username;}


    public function getProfileData()
    {
        return DB::table('users')
            ->where('username', '=', $this->username)
            ->get()->first();
    }

}