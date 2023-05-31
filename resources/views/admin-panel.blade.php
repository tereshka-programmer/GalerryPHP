@extends('/layouts.app')

@section('content-block')
    <style>
        a {
            text-decoration: none; /* Отменяем подчеркивание у ссылки */
        }

        .right {
            float: right;
        }
        .layer{
            margin: 2%;
        }
    </style>

    <div class="container py-4 bg-white ">
        <form method="get"  id="select-form" action="{{ route('panel.new') }}">
            <div class="btn-group right">
                <button class="btn ">apply:</button>
                <select name="select" class="right" form="select-form"> <!--Supplement an id here instead of using 'name'-->
                    <option value="2">2</option>
                    <option value="4" >4</option>
                    <option value="6">6</option>
                </select>

            </div>

        </form>


        <br>
        <br>
{{--        <form method="post" action="{{route('group.action')}}">--}}

{{--        </form >--}}

        @foreach($pictures as $picture)
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">

                <div class="col-5 d-none d-lg-block">
                    <img class="card-img-top" src="{{$picture->getPublicUrl()}}" alt="">
                </div>

                <div class="col p-4 d-flex flex-column position-static">
                    <h3 class="mb-0">{{$picture->title}}</h3><br>
                    <div class="mb-1 text-muted">{{$picture->created_at}}</div>
                    <p class="card-text mb-auto">{{$picture->description}}</p>

                    <div class="btn-group">
                        @if($picture->isDraft())
                            <form action="{{route('picture.publish', $picture)}}" method="post">
                                @csrf
                                <button class="btn btn-success" >Post </button>
                            </form>
                            <form action="{{route('picture.hide', $picture)}}" method="post">
                                @csrf
                                <button class="btn btn-success" >Hide </button>
                            </form>
                            <label class="list-group-item d-flex gap-2">
                                <input class="form-check-input flex-shrink-0" type="checkbox" name="picture_add"
                                       value="{{$picture->id}}">
                                <span>
                                        add
                                     </span>
                            </label>

                        @endif
                    </div>

                    <br>
                </div>
                @if($picture->isPublished())
                    <div class="container py-4 bg-white ">
                        @foreach($picture->waitingForApprovalReviews as $review)
                            <div class="container alert alert-warning">
                                <h3>{{$review->subject}}</h3>
                                <b>{{$review->email}}</b>
                                <p>{{$review->message}}</p>

                                <div class="btn-group">
                                    <form action="{{route('review.publish', $review)}}" method="post">
                                        @csrf
                                        <button class="btn btn-success" >Post </button>
                                    </form>
                                    <form action="{{route('review.hide', $review)}}" method="post">
                                        @csrf
                                        <button class="btn btn-success" >Hide </button>
                                    </form>

                                    <label class="list-group-item d-flex gap-2">
                                        <input class="form-check-input success flex-shrink-0" type="checkbox"
                                               name="review_add"
                                               value="{{$review->id}}">
                                        <span>
                                    add
                                </span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        @endforeach
    </div>

    <div class="container py-3">
        {{ $pictures->links() }}
    </div>

@endsection
