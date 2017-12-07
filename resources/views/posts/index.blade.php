<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <form>
                @foreach($posts as $post)

                    <div class="panel panel-default">

                        <div class="panel-heading"><h3 class="panel-title"><img src="{{URL::asset('images/title_logo.png')}}" height="32" width="32"> {{ $post->title }}
                                @if($post->user->name ==  Auth::user()->name)
                                    <div class="buttons pull-right">
                                        <a href="#">
                                        <img src="{{URL::asset('images/edit_logo.png')}}" height="28" width="28"> &nbsp;
                                            </a>
                                        <a href="#">
                                        <img src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20">
                                            </a>
                                    </div>
                                @endif</h3></div>
                        <div class="panel-body">Įrašas: {!! html_entity_decode($post->content) !!}</div>
                        <div class="panel-footer">
                            <img src="{{URL::asset('images/user_logo.png')}}" height="23" width="23">     {{ $post->user->name }} &nbsp; &nbsp;
                            <img src="{{URL::asset('images/date_logo.png')}}" height="23" width="23"> {{  $post->created_at }} &nbsp; &nbsp;
                            <img src="{{URL::asset('images/comment_logo.png')}}" height="23" width="23"> &nbsp; {{ $post->comment->count()}} &nbsp; Read comments..
                            <div class="pull-right">
                                <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23"> {{ $post->category->name }}</div>
                        </div>
                    </div>
                @endforeach
                </form>
            </div>
            </div>
    </div>
@endsection
