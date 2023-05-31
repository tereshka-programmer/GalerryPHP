@extends('/layouts.app')
@section('title-block')
    Login
@endsection

@section('content-block')
    <div class="container py-4 bg-white">
        <h1>Login</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <form method="post" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" id="email" placeholder="Enter email" class="form-control" value="{{session()->getOldInput('email')}}"><br>
            <input type="password" name="password" id="password" placeholder="Enter password" class="form-control" value="{{session()->getOldInput('password')}}"><br>
            <button type="submit" class="btn btn-success">Login</button>
        </form>
        <br>
        @env('production')
            <div class="btn-group">
                <form method="post" action="{{ route('auth.admin') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Admin</button>
                </form>
                <form method="post" action="{{ route('auth.author') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Author</button>
                </form>
                <form method="post" action="{{ route('auth.user') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">User</button>
                </form>

            </div>
        @endenv
    </div>
@endsection
