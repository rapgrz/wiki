@extends('layouts.app')

@section('content')
    @if(Auth::user()->access_level >= 3)
    <link rel="stylesheet" href="{{ URL::asset('css/categories_edit.css') }}" />
    <div class="container">
    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('category_update', ['category_id' => $categories->id]) }}" method="POST">
                {{ csrf_field() }}
                <label for="category">Edit category</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Title" name="name" maxlength="30" value="{{$categories->name}}" required><br><br>
                <input type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want update this category?')" value="Update category"></form>
            <span class="cancel">
            <button class="btn btn-default" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                </span>
        </div>
        </div>
        </div>
    @else
    You have no permission to see this
    @endif
@endsection