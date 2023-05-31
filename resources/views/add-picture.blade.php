@extends('/layouts.app')
@section('title-block')
    Add Picture
@endsection

@section('content-block')
    <style>
        a {
            text-decoration: none; /* Отменяем подчеркивание у ссылки */
        }

        .right {
            float: right;
        }
    </style>
    <div class="container py-4 bg-white">
        <a class="btn right" href="{{route('home')}}">Back</a>
        <h1>Add Picture</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <form method="post" enctype="multipart/form-data" action="{{ route('picture.create') }}">
            @csrf

            <input type="text" name="title" id="subject" placeholder="Enter title" class="form-control" value="{{session()->getOldInput('title')}}"><br>
            <textarea name="description" id="description" class="form-control"
                      placeholder="Enter description"></textarea><br>
            <input class="form-control" type="file" name="user_file" value="{{session()->getOldInput('user_file')}}"><br>
            <button type="submit" class="btn btn-success" >Add Picture>></button>
        </form>

    </div>
@endsection
