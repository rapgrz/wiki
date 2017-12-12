@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('posts.update') }}" method="POST">
                <label for="category">Edit category</label>
                 <textarea name="category">$category->id</textarea><br>
                <input type="submit" class="btn btn-primary" value="Update category">
                </form>
            </div>
        </div>
        </div>
@endsection