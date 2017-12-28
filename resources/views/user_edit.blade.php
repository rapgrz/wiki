@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/categories_edit.css') }}" />
    <div class="container">
        <div class="row">
            @if($user->email == Auth::user()->email || Auth::user()->access_level == 10)
            <div class="col-md-7">
                <form action="{{ route('userUpdate', ['user_id' => $user->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <strong>Edit user</strong>
                    <h4>{{$user->name}}</h4>
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name="email" maxlength="50" value="{{$user->email}}" required><br>
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter username" value="{{$user->name}}" required><br>
                    @if(Auth::user()->access_level == 10)
                    <label for="access">Access level</label>
                    <select id="access" class="form-control" name="access" required>
                        <option selected>{{$user->access_level}}</option>
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
                    @endif
                    <input type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want update this user?')" value="Update user"></form>
            <span class="cancel">
            <button class="btn btn-default" onclick="window.location='{{ URL::previous() }}'">Cancel</button>
                </span>
            </div>
                @else
            You have no permission to see this
                @endif
        </div>
    </div>
@endsection