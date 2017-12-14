@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('css/comments.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <div class="container">
    <div class="row">
        <div class="col-md-2">
            <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23">&nbsp;Categories <br><br>
            <div class="panel panel-default">
                        <span class="categories">
                @foreach($categories as $category)
                                <div class="panel-footer">
                                <a href="{{ route('search_category', ['category_id' => $category->id]) }}">
                    {{$category->name}} </a><br>
                    </div>
                            @endforeach
                        </span>
            </div>
        </div>
        <div class="col-md-10">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3 class="panel-title"><span class="title"><img src="{{URL::asset('images/title_logo.png')}}" height="35" width="35"></span> {{ $post->title }}
                            @if($post->user->email == Auth::user()->email)
                                <div class="buttons pull-right">
                                    <span class="edit"><a href="{{ route('post_edit',['post_id' => $post->id ] ) }}"><img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a></span>
                                    {{ Form::open([ 'method'  => 'post', 'route' => [ 'post_delete', $post->id ] ]) }}
                                    <span class="destroy"><input type="image" onclick="return confirm('Are you sure you want delete this post?')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/></span>
                                    {{ Form::close() }}
                                </div>
                            @endif</h3></div>
                    <div class="panel-body"> {!! html_entity_decode($post->content) !!}</div>
                    <div class="panel-footer">
                        <img src="{{URL::asset('images/user_logo.png')}}" height="23" width="23">     {{ $post->user->name }} &nbsp; &nbsp;
                        <img src="{{URL::asset('images/date_logo.png')}}" height="23" width="23"> {{  $post->created_at }} &nbsp; &nbsp;
                        <img src="{{URL::asset('images/comment_logo.png')}}" height="23" width="23"> &nbsp; {{ $post->comment->count()}} &nbsp;
                        <div class="pull-right">
                            <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23"> {{ $post->category->name }}</div>
                    </div>
                </div>
        </div>
        <div class="col-sm-10">
            <h3>Add comment</h3>
            <form action="{{ route('addComment', ['post_id' => $post->id]) }}" method="POST">
                {{ csrf_field() }}
                <textarea name="content"></textarea><br>
                <button type="submit" class="btn btn-primary">Add comment</button>
                        </form>
            <br>
            </div>
        <div class="col-sm-10">
            <h3>Post comments</h3>
        @foreach($post->comment as $comment)
        <div class="row">
            <div class="col-sm-1">
                <div class="thumbnail">
                    <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                </div>
            </div>

            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ $comment->user->name }}</strong> <span class="text-muted">commented {{$comment->created_at}}</span>
                        @if($comment->user->email == Auth::user()->email)
                        <div class="buttons pull-right">
                            <span class="editComment"><a href="{{ route('editComment',['comment_id' => $comment->id ] ) }}"><img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a></span>
                            {{ Form::open([ 'method'  => 'post', 'route' => [ 'destroyComment', $comment->id ] ]) }}
                            <span class="destroyComment"><input type="image" onclick="return confirm('Are you sure you want delete this comment?')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/></span>
                            {{ Form::close() }}
                        </div>
                            @endif
                    </div>
                    <div class="panel-body">
                        {!! html_entity_decode($comment->content) !!}
                    </div>
                </div>
            </div>
            </div>
            <br>
        @endforeach
        </div>
    </div>
    </div>
@endsection
