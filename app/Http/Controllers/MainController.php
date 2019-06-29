<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Charts\SampleChart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersCounter = DB::table('users')->count();
        $coinsCounter = DB::table('coins')->count();

        return view('home', [
            'usersCounter' => $usersCounter,
            'coinsCounter' => $coinsCounter,
        ]);
    }



    /**
    * Show tools page.
    * @return \Illuminate\Http\Response
    */
    public function tools()
    {
        // $chromeExt = "https://chrome.google.com/webstore/detail/codeforces-green-dot/hkdknjllamblhnehflcgeabkhkldpjcg";
        // //Get the nb of users
        // $file_string = file_get_contents($chromeExt);
        // preg_match('#>([0-9,]*) users</#i', $file_string, $users);
        // $nbusers = str_replace(",", "",$users[1]);

        $usersCounter = DB::table('users')->count();

        return view('tools', [
            'cfgreendotUsers' => 0,
            'coinUsers' => $usersCounter
        ]);
    }



    public function ask()
    {
        return Redirect::to('https://khaledalam.net');
    }

}
