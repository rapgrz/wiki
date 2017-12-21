@extends('layouts.app')

@section('content')
    @if($post->user->email == Auth::user()->email || Auth::user()->access_level >= 3)
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

                <form action="{{ route('post_update', ['post_id' => $post->id]) }}" method="POST">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Title" name="title" maxlength="70" value="{{$post->title}}" required><br>
                    <label for="category">Choose category</label>

                    <select id="category" class="form-control" name="category_id" required>
                        @foreach($categories as $category):
                        <option value="{{ $category->id }}" @if($post->category->id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select><br>
                    {{ csrf_field() }}
                    <textarea name="content">{{$post->content}}</textarea><br>
                    <input type="submit" class="btn btn-primary" value="Update Post">
                </form>

            </div>
        </div>
    </div>
    @else
    You have no permission to see this
    @endif
@endsection