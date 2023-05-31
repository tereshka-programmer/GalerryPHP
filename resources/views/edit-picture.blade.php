@extends('/layouts.app')
@section('title-block')
    Edit picture
@endsection

@section('content-block')
    <style>
        a {
            text-decoration: none; /* Отменяем подчеркивание у ссылки */
        }

        .right {
            float: right;
        }
        .left{
            float: left;
        }
    </style>
    <div class="container py-4 bg-white">

        <h1>Edit Picture</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">

            <div class="col-5 d-none d-lg-block">
                <img class="card-img-top" src="{{$picture->getPublicUrl()}}" alt="">

            </div>

            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">{{$picture->title}}</h3><br>
                <div class="mb-1 text-muted">{{$picture->created_at}}</div>
                <p class="card-text mb-auto">{{$picture->description}}</p>
            </div>

        </div>

            @can('delete', $picture)
            <form method="post" enctype="multipart/form-data" action="{{route('picture.update', $picture)}}">
                @csrf
                @method('PUT')
                <input type="text" name="title" id="title" value="{{$picture->title}}" class="form-control"><br>
                <textarea name="description" id="description" class="form-control"
                          placeholder="{{$picture->description}}"></textarea><br>
                <input class="form-control" type="file" name="user_file"><br>
                <div class="btn-group">
                <button type="submit" class="btn btn-success">Edit</button>
            </form>
            @endcan

            <a class="btn left " href="{{route('picture.preview', $picture)}}">Cancel</a>

            @can('delete', $picture)
                <form action="{{route('picture.delete', $picture)}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

@endsection

