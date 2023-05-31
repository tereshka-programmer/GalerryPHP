@extends('/layouts.app')
@section('title-block')
    Registration
@endsection

@section('content-block')
    <div class="container py-4 bg-white">
        <h1>Registration</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <form method="post" action="{{ route('registration') }}">
            @csrf
            <input type="text" name="email" id="email" placeholder="Enter email" class="form-control"
                   value="{{session()->getOldInput('email')}}"><br>
            <input type="password" name="password" id="password" placeholder="Enter password" class="form-control"
                   value="{{session()->getOldInput('password')}}"><br>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   placeholder="Confirm password" class="form-control"
                   value="{{session()->getOldInput('password_confirmation')}}"><br>
            <input type="text" name="first_name" id="first_name" placeholder="Enter first name"
                   class="form-control" value="{{session()->getOldInput('first_name')}}"><br>
            <input type="text" name="last_name" id="last_name" placeholder="Enter last name" class="form-control"
                   value="{{session()->getOldInput('last_name')}}"><br>
            <label class="list-group-item d-flex gap-2">
                <input class="form-check-input flex-shrink-0" type="checkbox" name="author" value="author" >
                <span>
                            Author
                            <small class="d-block text-muted">Get the ability to publish pictures</small>
                         </span>
            </label>
            <br>
            <button type="submit" class="btn btn-success">Registration</button>
        </form>

    </div>
@endsection


