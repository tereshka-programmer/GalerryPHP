@extends('/layouts.app')
@section('title-block')
    Profile
@endsection

@section('content-block')
    <div class="container py-4 bg-white">


        <h1>Profile</h1>


        <div class="alert alert-warning">
            Email: <b>{{$user->email}}</b>
            <br>First name: <b> {{$user->first_name}}</b>
            <br>First name: <b> {{$user->last_name}}</b>
            <br>Role: <b> {{$user->role}}</b>
        </div>

        <div>
            <a class="btn btn-success" href="{{route('profile.edit')}}">Edit</a>
        </div>


        <br>
    </div>
@endsection
