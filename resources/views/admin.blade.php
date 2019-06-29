@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            <div class="card">
                <div class="card-header">Tools list</div>

                <div class="card-body">

                    <a class="btn btn-primary" href="{{ route('addCoins')}}">Add Coins</a>

                    <a class="btn btn-info" href="{{ route('updateCoins')}}">Update Coins</a>

                    <a class="btn btn-danger" href="{{ route('deleteCoins')}}">Delete Coins</a>

                    <a class="btn btn-primary" href="{{ route('coinsPage')}}">Show Coins</a>
                    <small>Coins:</small> {{ $coinsCounter }}

                    <hr>

                    {{--@foreach($coins as $coin)--}}
                        {{--<span>{{ $coin->ticker }}</span>--}}
                    {{--@endforeach--}}
                </div>

            </div>

            <hr>

            <div class="card">
                <div class="card-header">Users list</div>

                <table class="table table-bordered justify-content-center">
                    <thead>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>IP</th>
                    <th>Last Visit</th>
                    <th>Join</th>
                    <th>Admin</th>

                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->ip }}</td>
                            <td>{{ Carbon\Carbon::parse($user->last_login_date)->diffForHumans() }}</td>
                            <td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
                            <td>{{ ($user->admin == 0 ? 'No' : 'Yes') }}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>




        </div>

    </div>
</div>


@endsection


