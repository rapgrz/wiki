@extends('layouts.app')

@section('content')

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                {{// Form::model($post, array('route' => array('posts.update', $post->id), 'method' => 'PUT')) }}
                <form action="{{ route('posts.update') }}" method="POST">
                    <label for="title">{{$post->title}}</label>
                    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Title" name="title" maxlength="70" required><br>
                    <label for="category">Choose category</label>

                    <select id="category" class="form-control" name="category_id" required>
                        <option selected>{{$post->category}}</option>
                        @foreach($categories as $category):
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select><br>
                    {{ csrf_field() }}
                    <textarea name="content">{{$post->content}}</textarea><br>
                    <input type="submit" class="btn btn-primary" value="Update Post">
                </form>

            </div>
        </div>
    </div>
@endsection