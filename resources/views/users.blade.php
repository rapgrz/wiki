@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ URL::asset('css/categories.css') }}" />
@if(Auth::user()->access_level == 10)
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <label for="title">Manage existing users</label>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Access level</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->access_level}}</td>
                            <td>
                                <span class="edit"><a href="{{ route('userEdit',['user_id' => $user->id ] ) }}">
                                        <img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a></span>&nbsp;
                                {{ Form::close() }}
                                {{ Form::open([ 'method'  => 'post', 'route' => [ 'userDelete', $user->id ] ]) }}
                                <span class="destroy">
                                        <input type="image" onclick="return confirm('Are you sure you want delete this user? All his posts and information will be deleted.')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/>
                                    </span>
                                {{ Form::close() }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@else
    You have no permissions to see this content
@endif
@endsection