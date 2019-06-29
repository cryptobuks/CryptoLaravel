@extends('layouts.app')

@section('page-title')
    Coin tool | {{ config('app.name') }}
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            <div class="card">
                <div class="card-header">Coins List <small>({{count($coins)}} coins)</small></div>

                <div class="card-body">
                    <div >
                        <p class="d-inline-block">Select a Coin:</p><br>

                        @foreach ($coins as $coin)
                            <a class="btn btn-sm btn-info m-1" href="{{url('tools/coin', $coin->ticker) }}">{{ $coin->ticker }}</a>
                        @endforeach

                    </div>


                </div>
            </div>


            <hr>

            <div class="card">

            </div>
        </div>
    </div>
</div>


@endsection


