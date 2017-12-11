@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/categories.css') }}" />
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
                    <label for="title">Manage existing category</label>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            <td>
                                <span class="edit"> <input type="image" src="{{URL::asset('images/edit_logo.png')}}" height="28" width="28"/></span>&nbsp;
                            {{ Form::open([ 'method'  => 'delete', 'route' => [ 'categories.destroy', $category->id ] ]) }}
                                    <span class="destroy"> <input type="image" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/></span>
                            {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                            </tbody>
                    </table>
            </div>
        </div>
    </div>
@endsection