
@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23">&nbsp;Categories <br><br>
                <div class="panel panel-default">
                        <span class="categories">
                @foreach($categories as $category)
                                <div class="panel-footer">
                    {{$category->name}} <br>
                    </div>
                @endforeach
                        </span>
                    </div>
            </div>
            <div class="col-md-10">
                @foreach($posts as $post)
                    <div class="panel panel-default">
                        <div class="panel-heading"><h3 class="panel-title"><span class="title"><img src="{{URL::asset('images/title_logo.png')}}" height="35" width="35"></span> {{ $post->title }}
                                @if($post->user->email == Auth::user()->email)
                                    <div class="buttons pull-right">
                                        <span class="edit"><a href="{{ route('post_edit',['post_id' => $post->id ] ) }}"><img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a></span>
                                        {{ Form::open([ 'method'  => 'post', 'route' => [ 'post_delete', $post->id ] ]) }}
                                        <span class="destroy"><input type="image" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/></span>
                                        {{ Form::close() }}
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
                <div class="links pull-right">
                {{ $posts->links() }}
            </div>
            </div>
            </div>
    </div>
@endsection
