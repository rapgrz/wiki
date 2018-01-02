@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/comments.css') }}" />
@endpush
@section('content')
    @if(Auth::user()->access_level == 10)
        <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
            <h2>
                Dashboard
            </h2>
            <hr>
                    <div>
            </div>
            <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body bg-warning">
                        <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total posts &nbsp;&nbsp;<strong><div class="counter d-inline float-right" data-count="{{$posts->count()}}">0</div></strong>
                        </div>
                    </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body bg-warning">
                        <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total comments &nbsp;&nbsp;<strong><div class="counter d-inline float-right" data-count="{{$comments->count()}}">0</div></strong>
                        </div>
                    </div>
            </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body bg-warning">
                            <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total categories &nbsp;&nbsp;<strong><div class="counter d-inline float-right" data-count="{{$categories->count()}}">0</div></strong>
                        </div>
                    </div>
                </div>
             <div class="col">
                 <div class="card">
                     <div class="card-body bg-warning">
                         <img src="{{URL::asset('images/statistics.png')}}"  height="23" width="23"/>&nbsp;
                            Total users &nbsp;&nbsp; <strong><div class="counter d-inline float-right" data-count="{{$users->count()}}">0</div></strong>
                         </div>
                     </div>
             </div>
                </div>
                <div class="row mt-2">
                    <div class="col">
                        <div class="card">
                            <div class="card-body bg-warning">
                                <img src="{{URL::asset('images/title_logo.png')}}"  height="40" width="40"/>&nbsp;
                                Latest post &nbsp;<br> <strong>{{$latestPost->title}}</strong><br>
                                Created &nbsp; <div class="float-right"><strong>{{$latestPost->created_at}}</strong></div><br>
                                By &nbsp;<div class="float-right"> <strong>{{$latestPost->user->name}}</strong></div>
                                </div>
                            </div>
                        </div>
                    <div class="col">
                        <div class="card">
                            <div class="card-body bg-warning">
                                <img src="{{URL::asset('images/comment_logo.png')}}"  height="23" width="23"/>&nbsp;
                                Latest comment <br><strong>{!! str_limit(html_entity_decode($latestComment->content), 105) !!}</strong><br>
                                On <strong>{{$latestComment->post->title}}</strong><br>
                                Commented by <strong>{{$latestComment->user->name}}</strong>
                                </div>
                            </div>
                    </div>
        </div>
        @else
        You have no permission to see this.
    @endif

@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $('.counter').each(function() {
        var $this = $(this),
                countTo = $this.attr('data-count');

        $({ countNum: $this.text()}).animate({
                    countNum: countTo
                },

                {

                    duration: 1000,
                    easing:'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                        //alert('finished');
                    }

                });
    });
    </script>
@endpush