@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row justify-content-center text-center">

        <div class="col-12">

            @if(session()->has('message.level'))
                <div class="alert alert-{{ session('message.level') }}">
                    {!! session('message.content') !!}
                </div>
            @endif

            @guest
                <span>
                    <a href="login">Login</a> or <a href="/register">Register</a> to use our free <a href="/tools" target="_blank">Tools</a>.
                </span>
            @endguest

        </div>

    </div>

</div>


@endsection
