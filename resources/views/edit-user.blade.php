@extends('/layouts.app')
@section('title-block')
    User-edit
@endsection

@section('content-block')
    <div class="container py-4 bg-white">
        <h1>Edit Information</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <form method="post" action="{{ route('profile.update') }}">
            @method('PUT')
            @csrf
            <input type="text" name="first_name" id="first_name" value="{{auth()->user()->first_name}}"
                   class="form-control"><br>
            <input type="text" name="last_name" id="last_name" value=" {{auth()->user()->last_name}}"
                   class="form-control"><br>
            @if(auth()->user()->role != \App\Enum\Role::Author->value)
                <label class="list-group-item d-flex gap-2">
                    <input class="form-check-input flex-shrink-0" type="checkbox" name="author" value="author">
                    <span>
                                Author
                                <small class="d-block text-muted">Get the ability to publish pictures</small>
                             </span>
                </label>
                <br>
            @endif

            <button type="submit" class="btn btn-success">Enter change</button>
        </form>

    </div>
@endsection
