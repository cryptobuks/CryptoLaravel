@extends('layouts.app')

@section('page-title')
    Coin tool | {{ config('app.name') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            <div class="card">
                <div class="card-header">
                    Coins Info
                    <div class="float-right" id="updated-from-link">
                        <small id="updated-from">updated: 0 second ago </small> <i class="fas fa-redo"></i>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 text-left">

                            <p class="col-md-12 p-0">Coin: <span class="border-bottom font-weight-bold">{{ $fromCoin->getTicker()->getName() }}</span></p>

                            <div class="col-md-12 p-0">
                                <span>Price: </span>
                                <div class="row">
                                    <div class="col-12">
                                        <span id="from-price-usd">{{ $fromCoin->getPriceInUSD() }}</span> <span id="price-unit">USD</span>
                                    </div>
                                    <div class="col-12">
                                        <span id="from-price-btc">{{ $fromCoin->getPriceInBTC() }}</span> <span id="price-unit">BTC</span>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-md-6 text-left">
                            <p class="col-md-12 p-0">Coin: <span class="border-bottom font-weight-bold">{{ $toCoin->getTicker()->getName() }}</span></p>

                            <div class="col-md-12 p-0">
                                <span>Price: </span>
                                <div class="row">
                                    <div class="col-12">
                                        <span id="to-price-usd">{{ $toCoin->getPriceInUSD() }}</span> <span id="price-unit">USD</span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            Other coins:
                            @foreach($otherCoins as $coin)
                                <a href="{{ route('coinPage', $coin) }}" class="btn btn-sm btn-primary">{{ $coin }}</a>
                            @endforeach
                            <a href="{{ route('coinsPage') }}" class="btn btn-sm btn-info">see all</a>
                        </div>
                    </div>
                </div>

            </div>


            <hr>

            <div class="card">
                <div class="card-header">Coin Price Converter</div>

                <div class="card-body">

                    <div class="container text-center">
                        <div class="row">
                            <div class="col">
                                <div class="d-inline-block">
                                    <label class="col-form-label">Amount: <small>({{ $fromCoin->getTicker()->getName() }})</small></label>
                                    <input class="input-group-text custom-select-sm" value="1" type="number" name="converter-coin-value" placeholder="0.0">
                                </div>

                                =

                                <div class="d-inline-block">
                                    <label class="col-form-label">Amount: <small>(USD)</small></label>
                                    <input class="input-group-text custom-select-sm" type="number" name="converter-usd-value" placeholder="0.0">
                                </div>

                                =

                                <div class="d-inline-block">
                                    <label class="col-form-label">Amount: <small>(BTC)</small></label>
                                    <input class="input-group-text custom-select-sm" type="number" name="converter-btc-value" placeholder="0.0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <hr>


            <div class="card">
                <div class="card-header">Trade Profitable Calculator</div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 text-center">
                            <p class="border-bottom font-weight-bold">BUY <small>({{ $fromCoin->getTicker()->getName() }})</small></p>

                            <div class="d-inline-block">
                                <label class="col-form-label">Amount: <small>({{ $fromCoin->getTicker()->getName() }})</small></label>
                                <input class="input-group-text custom-select-sm" type="number" name="from-amount" placeholder="0.0">
                            </div>

                            <div class="d-inline-block">
                                <label class="col-form-label">Price: <small id="from-current-per-btc">({{ $toCoin->getTicker()->getName() }})</small></label>
                                <input class="input-group-text custom-select-sm" type="number" name="from-price-per" placeholder="0.0">
                            </div>

                            <div class="d-inline-block">
                                <label class="col-form-label">Fees(%):</label>
                                <input class="input-group-text custom-select-sm" type="number" name="from-fees" placeholder="0.0">
                            </div>


                        </div>

                        <div class="col-md-6 text-center">

                            <p class="border-bottom font-weight-bold">SELL <small>({{ $fromCoin->getTicker()->getName() }})</small></p>

                            <div class="d-inline-block">
                                <label class="col-form-label">Amount: <small>({{ $fromCoin->getTicker()->getName() }})</small></label>
                                <input class="input-group-text custom-select-sm" type="number" name="to-amount" placeholder="0.0">
                            </div>

                            <div class="d-inline-block">
                                <label class="col-form-label">Price: <small id="to-current-per-btc">({{ $toCoin->getTicker()->getName() }})</small></label>
                                <input class="input-group-text custom-select-sm" type="number" name="to-price-per" placeholder="0.0">
                            </div>

                            <div class="d-inline-block">
                                <label class="col-form-label">Fees(%):</label>
                                <input class="input-group-text custom-select-sm" type="number" name="to-fees" placeholder="0.0">
                            </div>

                        </div>

                    </div>

                    <hr>

                    <div class="row d-none" id="result-section" >

                        <div class="col">
                            <small>Return on investment ~ <span id="USD-result"></span></small>
                        </div>

                    </div>

                </div>

            </div>


        </div>
    </div>
</div>


@endsection


@section('scripts')
    <script src="{{ asset('coin/js/coin.js') }}" defer></script>
@endsection