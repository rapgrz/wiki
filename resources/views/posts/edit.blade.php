@extends('layouts.app')

@section('content')
    @if($post->user->email == Auth::user()->email || Auth::user()->access_level >= 3)
        <link rel="stylesheet" href="{{ URL::asset('css/categories_edit.css') }}" />
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=re7zhthqsbfs0nmulqlphm57zxh66y0dnhdlstrjxrlnkoiz"></script>
    <script>tinymce.init({
            selector:'textarea',
            height: 150,
            plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
            ],
            toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
            toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
            toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
        });
    </script>
    <div class="container">
        <div class="row">
            <div class="col-md-7">

                <form action="{{ route('post_update', ['post_id' => $post->id]) }}" method="POST" enctype="multipart/form-data">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Title" name="title" maxlength="70" value="{{$post->title}}" required><br>
                    <label for="category">Choose category</label>

                    <select id="category" class="form-control" name="category_id" required>
                        @foreach($categories as $category):
                        <option value="{{ $category->id }}" @if($post->category->id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                            {{ csrf_field() }}
                    </select><br>
                    @if($files->count() > 0)
                    <label for="title">Attached files</label><br>
                    <div class="card">
                        <div class="card-body">
                    @foreach($files as $file)
                    {{$file->name}} <hr>
                    @endforeach
                        <div class="form-check float-right">
                            <input type="checkbox" class="form-check-input" id="Check" name="Check">
                            <label class="form-check-label" for="Check">Delete existing files</label>
                        </div>
                        <br>
                        </div>
                    </div>
                        <br>
                    @endif
                    <label for="file">Add files (you can attach more than one)</label>
                    <br />
                    <input type="file" name="file[]" multiple />
                    <br /><br />
                    <textarea name="content">{{$post->content}}</textarea><br>
                    <input type="submit" class="btn btn-primary" value="Update Post">
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