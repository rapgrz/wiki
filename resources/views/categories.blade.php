@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <form action="{{ route('saveCategory') }}" method="POST">
                    <label for="title">Type category name</label>
                    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Category" name="category" maxlength="30" required><br>

                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-primary" value="Create Category">
                </form>
                <br><br><br>
                <form action="" method="POST">
                    <label for="title">Update existing category</label>
                    <select id="category" class="form-control" name="category_id" required>
                        <option selected disabled>Choose...</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                    </form>
                </select>
            </div>
        </div>
    </div>
@endsection