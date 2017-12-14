@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/categories_edit.css') }}" />
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <form action="{{ route('userUpdate', ['user_id' => $users->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <strong>Edit user</strong>
                    <h4>{{$users->name}}</h4>
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" maxlength="50" value="{{$users->email}}" required><br>
                    <label for="access">Access level</label>
                    <select id="access" class="form-control" name="access" required>
                        <option selected>{{$users->access_level}}</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                    <br><br>
                    <input type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want update this user?')" value="Update user"></form>
            <span class="cancel">
            <button class="btn btn-default" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                </span>
            </div>
        </div>
    </div>
@endsection