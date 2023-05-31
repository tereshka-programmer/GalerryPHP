@extends('/layouts.app')

@section('content-block')
    <style>
        a {
            text-decoration: none; /* Отменяем подчеркивание у ссылки */
        }

        .right {
            float: right;
        }
    </style>

    <div class="album py-3 bg-light">
        <div class="container">
            <div class="btn-group right">
                @if(auth()->check()&& auth()->user()->author())
                    <a class="btn right  py-3" href="{{route('my.pictures.index')}}"> My pictures</a>
                @endif
                @if(auth()->check())
                    <a class="btn right  py-3" href="{{route('favourite.pictures.index')}}"> Favourite pictures</a>
                @endif
                <button class="btn" onclick="history.go(-1);">Back</button>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">

                @foreach($pictures as $picture)

                    <div class="col">
                        <div class="card shadow-sm">
                            <img class="card-img-top" src="{{$picture->getPublicUrl()}}" height="400" width="300"
                                 alt="">

                            <div class="card-body text-black">
                                <a class=" text-dark" href="{{route('picture.preview', $picture)}}">
                                    <h2>{{$picture->title}}</h2></a>

                                @if(auth()->check())
                                    <div class="btn-group">
                                        @if($picture->checkFavouriteStatus())
                                            <form class=" align-right py-2 "
                                                  action="{{route('favourite.picture.add', $picture)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/ordinary.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                        @else
                                            <form class=" align-right py-2 "
                                                  action="{{route('favourite.picture.delete', $picture)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{asset('images/favourite.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                        @endif
                                        @if($picture->wasLiked(1))
                                            <form class=" align-right py-2 "
                                                  action="{{route('picture.like', $picture, 1)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/like.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                            <form class=" align-right py-2 "
                                                  action="{{route('picture.dislike', $picture, -1)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/dislike_ordinary.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                        @elseif($picture->wasLiked(-1))
                                            <form class=" align-right py-2 "
                                                  action="{{route('picture.like', $picture, 1)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/ordinary_like.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                            <form class=" align-right py-2 "
                                                  action="{{route('picture.dislike' , $picture, -1)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/dislike.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                        @else
                                            <form class=" align-right py-2 "
                                                  action="{{route('picture.like', $picture, 1)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/ordinary_like.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                            <form class=" align-right py-2 "
                                                  action="{{route('picture.dislike', $picture, -1)}}" method="post">
                                                @csrf
                                                <button class="btn right"><img
                                                        src="{{ asset('images/dislike_ordinary.svg')}}"
                                                        height="40" width="40" border="0"/>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                @endif
                                <div class="d-flex justify-content-between align-items-center">
                                    @can('edit', $picture)
                                        <div class="btn-group">
                                            <a class="btn btn-sm btn-outline-secondary " role="button" type="submit"
                                               href="{{route('picture.edit', $picture)}}"> Edit</a>
                                            @endcan
                                            @can('delete', $picture)
                                                <form action="{{route('picture.delete', $picture)}}" method="post">
                                                    @csrf
                                                    <button class="btn btn-sm btn-outline-secondary" type="submit"
                                                            onclick="return confirm('Are you sure?')">Delete
                                                    </button>
                                                </form>

                                        </div>
                                    @endcan
                                    <small class="text-muted">{{$picture->updated_at}}</small>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="container py-3">
            {{ $pictures->links() }}
        </div>
    </div>
@endsection



