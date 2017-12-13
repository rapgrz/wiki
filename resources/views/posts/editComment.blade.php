@extends('layouts.app')

@section('content')

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    <div class="container">
        <div class="row">
            <div class="col-md-7">

                <form action="{{ route('updateComment', ['comment_id' => $comment->id]) }}" method="POST">
                    <label>Edit comment on post:</label>
                    {{ csrf_field() }}
                    <textarea name="content">{{$comment->content}}</textarea><br>
                    <input type="submit" class="btn btn-primary" value="Update Comment">
                </form>

            </div>
        </div>
    </div>
@endsection