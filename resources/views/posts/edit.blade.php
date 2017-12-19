@extends('layouts.app')

@section('content')
    @if($post->user->email == Auth::user()->email || Auth::user()->access_level >= 3)
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <div class="container">
        <div class="row">
            <div class="col-md-7">

                <form action="{{ route('post_update', ['post_id' => $post->id]) }}" method="POST">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Title" name="title" maxlength="70" value="{{$post->title}}" required><br>
                    <label for="category">Choose category</label>

                    <select id="category" class="form-control" name="category_id" required>
                        @foreach($categories as $category):
                        <option value="{{ $category->id }}" @if($post->category->id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select><br>
                    {{ csrf_field() }}
                    <textarea name="content">{{$post->content}}</textarea><br>
                    <input type="submit" class="btn btn-primary" value="Update Post">
                </form>

            </div>
        </div>
    </div>
    @else
    You have no permission to see this
    @endif
@endsection