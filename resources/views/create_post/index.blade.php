@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <div class="container">
        <div id="msg" class="mt-5"></div><br>
        <div class="row">
            <div class="col-md-7">
                <form action="{{ route('save_post') }}" method="POST" id="addPost">
                    <label for="title">Type your post title</label>
                    <input type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="Enter Title" name="title" maxlength="70" required><br>
                    <label for="category">Choose category</label>

                    <select id="category" class="form-control" name="category_id" required>
                        <option selected disabled>Choose...</option>
                        @foreach($categories as $category):
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select><br>
                    <input type="hidden" id="category_id" value="{{$category->id}}">
                    <input type="hidden" id="add_post_uri" value="{{ route('save_post')}}">
                    {{ csrf_field() }}
                    <textarea name="content" id="post_content"></textarea><br>
                    <input type="submit" class="btn btn-primary" value="Create Post" id="createPost">
                </form>

            </div>
        </div>
</div>
@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script>
    $("#addPost").on('submit', function (e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        var content = $("textarea#post_content").val();
        var title = $("#title").val();
        var category_id = $("#category_id").val();
        var uri = $("#add_post_uri").val();



    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var req = $.ajax({
    method: "POST",
    url: uri,
    data: { content: content, title: title, category_id: category_id},
    beforeSend: function (data) {
    $("#createPost").attr('disabled','disabled');
    $("#createPost").val('Please wait...');
    }
    });


    req.fail(function( data ) {

    var errorsHtml = '<div class="alert alert-danger"><ul>';

        $.each( data.responseJSON.errors.content, function( key, value ) {
        errorsHtml += '<li>' + value + '</li>';
        });
        errorsHtml += '</ul></div>';
    $( '#msg' ).html( errorsHtml );

    $("#createPost").attr('disabled', false);
    $("#createPost").val('Add comment');
});

    req.done(function( data ) {
        tinyMCE.activeEditor.setContent('');
    $("#title").val("");
    $("#category_id").html("1");
    $("#msg").html("");
    $("#msg").html("<div class='alert alert-success'>Your post has been added</div>");

    $ ("#createPost").attr('disabled', false);
    $("#createPost").val('Add comment');

});

});

</script>
@endpush