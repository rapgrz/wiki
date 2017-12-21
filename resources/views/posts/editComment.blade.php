@extends('layouts.app')

@section('content')
    @if($comment->user->email == Auth::user()->email || Auth::user()->access_level >= 10)
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

                <form action="{{ route('updateComment', ['comment_id' => $comment->id]) }}" method="POST">
                    <label>Edit comment on post:</label>
                    {{ csrf_field() }}
                    <textarea name="content">{{$comment->content}}</textarea><br>
                    <input type="submit" class="btn btn-primary" value="Update Comment">
                </form>

            </div>
        </div>
    </div>
    @else
    You have no permission to see this
    @endif
@endsection