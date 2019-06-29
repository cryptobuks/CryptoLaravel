@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">


            <div class="card">
                <div class="card-header">Tools list</div>

                <div class="card-body">

                    @guest
                        <span>
                            <a href="login">Login</a> or <a href="/register">Register</a> to use our free <a href="/tools" target="_blank">Tools</a>.
                        </span>

                    @else


                        <div class="card">

                            <table class="table table-hover">

                                <!--Table head-->
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tool Name</th>
                                    <th>Description</th>
                                    <th>Users</th>
                                </tr>
                                </thead>
                                <!--Table head-->

                                <!--Table body-->
                                <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td><a href="tools/coin">Coin Profitable and Converter</a></td>
                                    <td>Crypto currency coin converter and exchange trade profitable calculator tool.</td>
                                    <td>{{ $coinUsers - 2 }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td><a href="https://chrome.google.com/webstore/detail/codeforces-green-dot/hkdknjllamblhnehflcgeabkhkldpjcg?hl=en-US">Codeforces Green Dot</a> <small>(<a href="http://codeforces.com/blog/entry/49868">Announcement</a>)</small></td>
                                    <td>Google Chrome Extension to check recent actions happens on codeforces.com platform.</td>
                                    <td>{{ $cfgreendotUsers }}</td>
                                </tr>
                                </tbody>
                                <!--Table body-->

                            </table>
                        </div>

                    @endguest


                    <hr>

                    <small class="text-center d-block">Do you have interseting tool idea? or want to contribute <a href="mailto:#">contact</a> </small>

                </div>
            </div>





        </div>
    </div>
</div>


@endsection


