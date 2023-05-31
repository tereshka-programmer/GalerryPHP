@extends('/layouts.app')
@section('title-block')
    Picture Review
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
    <div class="container">
        <div class="btn-group right">

            @if(auth()->check() && auth()->user()->author())
                <form class=" align-right py-2 " action="{{route('waiting.reviews.index', $picture)}}" method="get">
                    <button class="btn right">Waiting Reviews</button>
                </form>
            @endif
            <a class="btn" href="{{route('home')}}">Back</a>
        </div>

    </div>
    <br>
    <div class="container py-4 bg-white">

        <br>
        <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">

            <div class="col-5 d-none d-lg-block">
                <img class="card-img-top" src="{{$picture->getPublicUrl()}}" alt="">

            </div>

            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0">{{$picture->title}}</h3><br>
                <div class="mb-1 text-muted">{{$picture->created_at}}
                    @if(auth()->check() && auth()->user()->author())
                        <p class="card-text mb-auto">Adding to
                            Favourites: {{auth()->user()->myFavouritesPictures()->count()}}</p>
                    @endif
                </div>
                <p class="card-text mb-auto">{{$picture->description}}</p>
                <div class="group py-4">
                    <p class="card-text mb-auto">Likes: {{$picture->likeCount(1)}}</p>
                    <p class="card-text mb-auto">Dislikes: {{$picture->likeCount(-1)}}</p>
                </div>
                <div class="btn-group">
                    @can('delete', $picture)
                        <form action="{{route('picture.delete', $picture)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    @endcan
                    @can('edit', $picture)
                        <form action="{{route('picture.edit', $picture)}}">
                            @csrf
                            <button class="btn btn-success">Edit</button>
                        </form>
                    @endcan
                </div>

            </div>

        </div>

        @if(auth()->check())
            <h1>
                Add Review
            </h1>

            <form method="post" action="{{route('review.add', $picture)}}">
                @csrf
                <input type="text" name="subject" id="subject" placeholder="Enter review" class="form-control"
                       value="{{session()->getOldInput('subject')}}"><br>
                <textarea name="message" id="message" class="form-control" placeholder="Enter text"></textarea><br>
                <button type="submit" class="btn btn-success">Add review</button>
            </form>

        @endif
        <br>
        @foreach($reviews as $review)
            @if(!$review->isRevoked() && !$review->isWaitingForApproval() )
                <div class="alert alert-warning">
                    <h3>{{$review->subject}}</h3>
                    <b>{{$review->email}}</b>
                    <p>{{$review->message}}</p>
                    @if(auth()->check())
                        <div class="btn-group">
                            @if($review->wasLiked(1))
                                <form class=" align-right py-2 "
                                      action="{{route('review.like', [$review])}}" method="post">
                                    @csrf
                                    <button class="btn right"><img
                                            src="{{ asset('images/like.svg')}}"
                                            height="30" width="30" border="0"/>
                                    </button>
                                </form>
                                <form class=" align-right py-2 "
                                      action="{{route('review.dislike', [$review])}}" method="post">
                                    @csrf
                                    <button class="btn right"><img
                                            src="{{ asset('images/dislike_ordinary.svg')}}"
                                            height="30" width="30" border="0"/>
                                    </button>
                                </form>
                            @elseif($review->wasLiked(-1))
                                <form class=" align-right py-2 "
                                      action="{{route('review.like', [$review, $picture])}}" method="post">
                                    @csrf
                                    <button class="btn right"><img
                                            src="{{ asset('images/ordinary_like.svg')}}"
                                            height="30" width="30" border="0"/>
                                    </button>
                                </form>
                                <form class=" align-right py-2 "
                                      action="{{route('review.dislike' , [$review, $picture])}}" method="post">
                                    @csrf
                                    <button class="btn right"><img
                                            src="{{ asset('images/dislike.svg')}}"
                                            height="30" width="30" border="0"/>
                                    </button>
                                </form>
                            @else
                                <form class=" align-right py-2 "
                                      action="{{route('review.like', [$review, $picture])}}" method="post">
                                    @csrf
                                    <button class="btn right"><img
                                            src="{{ asset('images/ordinary_like.svg')}}"
                                            height="30" width="30" border="0"/>
                                    </button>
                                </form>
                                <form class=" align-right py-2 "
                                      action="{{route('review.dislike', [$review, $picture])}}" method="post">
                                    @csrf
                                    <button class="btn right"><img
                                            src="{{ asset('images/dislike_ordinary.svg')}}"
                                            height="30" width="30" border="0"/>
                                    </button>
                                </form>
                            @endif
                            @endif
                        </div>
                </div>
            @elseif(auth()->check() && auth()->user()->pictureAuthor($picture) && $review->isRevoked())
                <div class="alert alert-warning">
                    banned
                    <h3>{{$review->subject}}</h3>
                    <b>{{$review->email}}</b>
                    <p>{{$review->message}}</p>
                </div>
            @elseif(auth()->check() && auth()->user()->pictureAuthor($picture)  && $review->isWaitingForApproval())
                <div class="alert alert-warning">

                    <h3>{{$review->subject}}</h3>
                    <b>{{$review->email}}</b>
                    <p>{{$review->message}}</p>

                    <div class="btn-group">
                        <form action="{{route('review.publish', $review)}}" method="post">
                            @csrf
                            <button class="btn btn-success">Post</button>
                        </form>
                        <form action="{{route('review.hide', $review)}}" method="post">
                            @csrf
                            <button class="btn btn-success">Hide</button>
                        </form>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="container">
            {{ $reviews->links() }}
        </div>

    </div>
@endsection
