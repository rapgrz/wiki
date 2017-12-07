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
                                    <input type="submit" value="Edit Post" class="btn btn-secondary btn-sm" name="edit">&nbsp;
                                        <input type="submit" value="Delete Post" class="btn btn-danger btn-sm" name="delete">
                                    </div>
                                @endif</h3></div>
                        <div class="panel-body">Įrašas: {!! html_entity_decode($post->content) !!}</div>
                        <div class="panel-footer">
                            <img src="{{URL::asset('images/user_logo.png')}}" height="23" width="23">     {{ $post->user->name }} &nbsp; &nbsp; &nbsp;
                            <img src="{{URL::asset('images/comment_logo.png')}}" height="20" width="20"> 0 &nbsp; &nbsp; Read comments..
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
