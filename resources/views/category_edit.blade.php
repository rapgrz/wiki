@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('category_update', ['category_id' => $categories->id]) }}" method="POST">
                {{ csrf_field() }}
                <label for="category">Edit category</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Title" name="name" maxlength="30" value="{{$categories->name}}" required><br><br>
                <input type="submit" class="btn btn-primary" value="Update category">
                </form>
            </div>
        </div>
        </div>
@endsection