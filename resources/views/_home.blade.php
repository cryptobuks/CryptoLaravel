@extends('layouts.app')

@section('page-title')
    {{ config('app.name') }}
@endsection

@section('content')

<div class="container">

    <div class="row justify-content-center text-center">

        <div class="col-12">

            <div class="card p-4 m-2">

                <span><h1 class="d-inline-block">Khaled Alam</h1> <small>aka Ninjo</small></span>
                <h3>Full stack developer</h3>
                <hr>

                @guest
                    <span>
                        <a href="login">Login</a> or <a href="/register">Register</a> to use our free <a href="/tools" target="_blank">Tools</a>.
                    </span>

                    @else
                        <span>Hi {{ Auth::user()->username }}, use our free <a href="/tools" target="_blank">Tools</a> now.</span>
                @endguest

            </div>



          </div>
    </div>

    <div class="row justify-content-center text-center">
        <div class="col-6">

            <div class="card p-2 m-1">

                <p><span class="badge badge-secondary">{{ $usersCounter + 3 }}</span> Registered Users</p>

                <p><span class="badge badge-secondary">{{ $coinsCounter }}</span> Unique <a href="{{ route('coinsPage') }}">Coins</a> in Our Database</p>


            </div>

            <div class="card p-2 m-1">

                <a href="{{ route('askPage') }}" target="_blank">ASK me anonymously</a>


            </div>



        </div>

        <div class="col-6">

            <div class="card p-2 m-1">

                <table class="table table-bordered justify-content-center">
                    <thead>
                    <th>Recent News</th>
                    </thead>
                    <tbody>
                    <tr><td> ></td></tr>
                    <tr><td> ></td></tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</div>


@endsection



{{--<script src=//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js charset=utf-8></script>--}}
{{--<script src=//cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js charset=utf-8></script>--}}
{{--<script src=//cdn.jsdelivr.net/npm/fusioncharts@3.12.2/fusioncharts.js charset=utf-8></script>--}}
{{--<script src=//cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>--}}

</span>