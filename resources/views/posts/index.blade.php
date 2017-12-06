<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                @foreach($posts as $post)
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title"><img src="{{URL::asset('images/title_logo.png')}}" height="32" width="32"> {{ $post->title }}</h3></div><div class="panel-body">Įrašas: {!! html_entity_decode($post->content) !!}</div>
                        <div class="panel-footer"><img src="{{URL::asset('images/user_logo.png')}}" height="23" width="23">     {{ $post->author }} <div class="pull-right"><img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23"> Category: </div></div>
                    </div>
                @endforeach
            </div>
            </div>
    </div>

@endsection
