@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/comments.css') }}" />
@endpush
@section('content')
    @if($user->email == Auth::user()->email || Auth::user()->access_level >= 10)
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 lead">User profile<hr></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img class="img-circle avatar avatar-original" style="-webkit-user-select:none;
              display:block; margin:auto;" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png"><br>
                                <button class="btn btn-default">Change logo</button>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="only-bottom-margin">{{$user->name}}</h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="text-muted">Email:</span> {{$user->email}}<br>
                                        <span class="text-muted">Access level:</span> <strong>{{$user->access_level}}</strong><br>
                                        <span class="text-muted">Posts:</span> {{$posts->count()}}<br>
                                        <span class="text-muted">Comments:</span> {{$comments->count()}}<br><br>
                                        <small class="text-muted">Created: {{substr(Auth::user()->created_at, 0, 10)}}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <form action="{{ route('userEdit',['user_id' => $user->id ]) }}">
                                    <input type="submit" class="btn btn-primary float-right" value="Edit" />
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        You have no permission to see this
        @endif
<hr>
@endsection
@push('scripts')
@endpush