@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ URL::asset('css/categories_edit.css') }}" />
@endpush
@section('content')
    @if($user->email == Auth::user()->email | Auth::user()->access_level == 10)
        <div class="container">
            <div class="row">
                <div class="col-md-8 mt-5 ml-5">
                    <form enctype="multipart/form-data" action="{{route('saveAvatar')}}" method="POST">
                        <label>Update Profile Image</label><br>
                        <input type="file" name="avatar">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"><br><br>
                        <input type="submit" class="btn btn-primary" value="Upload">
                    </form>
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