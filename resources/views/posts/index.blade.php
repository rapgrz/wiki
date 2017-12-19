
@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
@endpush
@section('content')

    <!--- SEARCH block -->
    <span class="filter">
    <div class="row mt-5 mb-5">
        <div class="col"></div>
        <div class="form-row">
        <form action="{{ route('post_search') }}" method="POST" class="form-inline">
            <div class="col">
            <select id="searchBy" class="form-control" name="searchBy">
                <option value="title">Title</option>
                <option value="content">Content</option>
            </select>
            </div>

            {{ csrf_field() }}
            <div class="col">
            <input type="text" class="form-control"  placeholder="Search by selected filter" name="search">
            </div>
            <div class="col">
            <button type="submit" class="btn btn-primary btn">Search</button></span></div>
            </form>

        </div>
        <div class="col"></div>
    </div>
    <!--- Search block --->


    <div class="container">
        <div class="row">

                    </div>
                </div>

            </div>
    </div>
        <div class="row">
            <div class="col-md-2">
                <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23">&nbsp;Categories <br><br>
                <div class="card">
                        <span class="categories">
                @foreach($categories as $category)
                                <div class="card-footer">
                                <a href="{{ route('search_category', ['category_id' => $category->id]) }}">
                    {{$category->name}} </a><br>
                    </div>
                @endforeach
                        </span>
                    </div>
            </div>
            <div class="col-md-10">
                @foreach($posts as $post)
                    <div class="card">
                        <div class="card-header"><h3 class="card-title"><span class="title"><img src="{{URL::asset('images/title_logo.png')}}" height="40" width="40"></span>
                                <a href="{{ route('postShow', ['post_id' => $post->id]) }}">{{ $post->title }}</a>
                                @if($post->user->email == Auth::user()->email || Auth::user()->access_level >= 5)
                                    <div class="buttons float-right">
                                        <span class="edit">
                                            <a href="{{ route('post_edit',['post_id' => $post->id ] ) }}"><img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a>
                                        </span>
                                        {{ Form::open([ 'method'  => 'post', 'route' => [ 'post_delete', $post->id ] ]) }}
                                        <span class="destroy">
                                            <input type="image" onclick="return confirm('Are you sure you want delete this post?')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/>
                                        </span>
                                        {{ Form::close() }}
                                    </div>
                                @endif</h3></div>
                        <div class="card-body"> {!! str_limit(html_entity_decode($post->content), 500) !!}</div>
                        <div class="card-footer">
                            <img src="{{URL::asset('images/user_logo.png')}}" height="23" width="23">     {{ $post->user->name }} &nbsp; &nbsp;
                            <img src="{{URL::asset('images/date_logo.png')}}" height="23" width="23"> {{  $post->created_at }} &nbsp; &nbsp;
                            <img src="{{URL::asset('images/comment_logo.png')}}" height="23" width="23"> &nbsp; {{ $post->comment->count()}} &nbsp;
                            <a href="{{ route('postShow', ['post_id' => $post->id]) }}"> Read full post.. </a>
                            <div class="cats float-right">
                                <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23"> {{ $post->category->name }}</div>
                        </div>
                    </div>
                    <br>
                @endforeach
                <div class="links float-right">
                {{ $posts->links('') }}
            </div>
            </div>
            </div>

@endsection
