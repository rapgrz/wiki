@extends('layouts.app')
@push('css')
<link rel="stylesheet" href="{{ URL::asset('css/posts.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('css/comments.css') }}" />
@endpush

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2">
                <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23">&nbsp;Categories <br><br>
                <div class="card">
                        <span class="categories">
                @foreach($categories as $category)
                                <div class="card-footer">
                                <a href="{{ route('search_category', ['category_id' => $category->id]) }}">
                    {{$category->name}} </a><br>
                    </div>
                            @endforeach
                        </span>
                </div>
            </div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header"><h3 class="card-title"><span class="title"><img src="{{URL::asset('images/title_logo.png')}}" height="35" width="35"></span> {{ $post->title }}
                            @if($post->user->email == Auth::user()->email || Auth::user()->access_level >= 5)
                                <div class="buttons float-right">
                                    <span class="edit"><a href="{{ route('post_edit',['post_id' => $post->id ] ) }}"><img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a></span>
                                    {{ Form::open([ 'method'  => 'post', 'route' => [ 'post_delete', $post->id ] ]) }}
                                    <span class="destroy"><input type="image" onclick="return confirm('Are you sure you want delete this post?')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/></span>
                                    {{ Form::close() }}
                                </div>
                            @endif</h3></div>
                    <div class="card-body"> {!! html_entity_decode($post->content) !!}</div>
                    <div class="card-footer">
                        <a href="/wiki/public/users/profile/{{$post->user->id }}">
                            <img src="{{URL::asset('images/user_logo.png')}}"  height="23" width="23"/>&nbsp; {{ $post->user->name }} </a> &nbsp; &nbsp;
                        <img src="{{URL::asset('images/date_logo.png')}}" height="23" width="23"> {{  $post->created_at }} &nbsp; &nbsp;
                        <img src="{{URL::asset('images/comment_logo.png')}}" height="23" width="23"> &nbsp; {{ $post->comment->count()}} &nbsp;
                        <div class="float-right">
                            <img src="{{URL::asset('images/category_logo.png')}}" height="23" width="23"> {{ $post->category->name }}</div>
                    </div>
                </div>
            </div>
            @if($fileCheck > 0)
            <div class="col-sm-10">
                <strong>Attached files</strong><br>
                @foreach($post->files as $file)
                    <a href="http://localhost/wiki/storage/app/{{$file->path}}" target="_blank" download><img src="{{URL::asset('images/folder_download.png')}}" height="40" width="40">&nbsp; {{ $file->name }}</a><br>
                    @endforeach
            </div><br><br>
            @endif
            <div class="col-sm-10">
                <hr>
                <div id="msg"></div>
                <h3>Add comment</h3>
                <form action="{{ route('addComment', ['post_id' => $post->id]) }}" method="POST" id="addComment">
                    {{ csrf_field() }}
                    <textarea id="comment_content"></textarea><br>
                    <input type="hidden" id="post_id" value="{{$post->id}}">
                    <input type="hidden" id="add_comment_uri" value="{{ route('addComment', ['post_id' => $post->id]) }}">
                    <button type="submit" class="btn btn-primary" id="confirmAdd">Add comment</button>
                </form>
                <hr>
            </div>
                <div class="col-sm-10">
                <h3>Post comments</h3>
                <div id="new_comment" class="row mb-3"></div>
                @isset($post->comment)
                @foreach($post->comment as $comment)
                    <div class="row">
                        <div class="col-sm-1">
                            <div class="thumbnail">
                                <img class="img-fluid user-photo" src="http://localhost/wiki/storage/app/{{$comment->user->avatar_path}}">
                            </div>
                        </div>
                        <div class="col-sm-11">
                            <div class="card">
                                <div class="card-header">
                                    <strong><a href="/wiki/public/users/profile/{{$comment->user->id }}">
                                           {{ $comment->user->name }} </a></strong>&nbsp;
                                    <span class="text-muted">commented {{$comment->created_at}}</span>
                                    @if($comment->user->email == Auth::user()->email || Auth::user()->access_level >= 5)
                                        <div class="buttons float-right">
                                            <span class="editComment">
                                                <a href="{{ route('editComment',['comment_id' => $comment->id ] ) }}"><img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30"/></a>
                                            </span>
                                            {{ Form::open([ 'id' => 'deleteComment', 'method'  => 'post', 'route' => [ 'destroyComment', $comment->id ] ]) }}
                                            <span class="destroyComment">
                                                <input type="image" id='destroyComment' onclick="return confirm('Are you sure you want delete this comment?')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/>
                                            </span>
                                            {{ Form::close() }}
                                        </div>
                                    @endif
                                </div>
                                <div class="card-body">
                                    {!! html_entity_decode($comment->content) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                @endforeach
                @endisset
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
<script>

    $("#addComment").on('submit', function (e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        var content = $("textarea#comment_content").val();
        var post_id = $("#post_id").val();
        var user_id = $("#user_id").val();
        var uri = $("#add_comment_uri").val();



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var req = $.ajax({
                    method: "POST",
                    url: uri,
                    data: { content: content, post_id: post_id},
                    beforeSend: function (data) {
                        $("#confirmAdd").attr('disabled','disabled');
                        $("#confirmAdd").val('Please wait...');
                    }
                }
        );


        req.fail(function( data ) {

            var errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each( data.responseJSON.errors.content, function( key, value ) {
                errorsHtml += '<li>' + value + '</li>';
            });
            errorsHtml += '</ul></div>';
            $( '#msg' ).html( errorsHtml );

            $("#confirmAdd").attr('disabled', false);
            $("#confirmAdd").val('Add comment');
        });

        req.done(function( data ) {
            var content = data.content;
            var post_id = data.post_id;
            var user_id = data.user_id;
            var user_name = data.user_name;
            var comment_id = data.comment_id;
            var created_at_raw = data.created_at.date;
            var user_avatar = data.user_avatar;
            var myarr = created_at_raw.split(" ");
            var created_at = myarr[0]+" "+myarr[1].substring(0, 8);
            tinyMCE.activeEditor.setContent('');
            var edit_url = '{{ route('posts') }}/edit/comment/'+comment_id;
            var destroy_url = '/wiki/public/post/comment/'+comment_id;

            console.log(created_at);
            var newComment = "<div class='col-sm-1'>"
                    +"<div class='thumbnail'>"
                    + "<img class='img-fluid user-photo' src='http://localhost/wiki/storage/app/"+user_avatar+"'>"
                    + "</div>"
                    + "</div>"
                    + "<div class='col-sm-11'>"
                    + "<div class='card'>"
                    + "<div class='card-header'>"
                    + "<strong>"
                    + "<a href='/wiki/public/users/profile/"+user_id+"'>"+user_name+"</a>"
                    + "</strong>&nbsp; <span class='text-muted'>commented&nbsp;"
                    + created_at
                    + "</span>"
                    + "@if('sadsadsad' == Auth::user()->email || Auth::user()->access_level >= 5)"
                    + "<div class='buttons float-right'>"
                    + "<span class='editComment'><a href='"+edit_url+"'><img src='{{URL::asset('images/edit_logo.png')}}'  height='30' width='30'/></a></span>"
                    + "<form method='post' action='"+destroy_url+"' > <input type='hidden' name='_token' value='{{ csrf_token() }}'>"
                    + "<span class='destroyComment'><input type='image' id='destroyNewComment' src='{{URL::asset('images/trash_logo.png')}}' height='20' width='20'/></span>"
                    + "</form>"
                    + "</div>"
                    + "@endif"
                    + "</div>"
                    + "<div class='card-body'>"
                    + content
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</br>";

            $("#new_comment").prepend(newComment);

            $("#msg").html("");
            $("#msg").html("<div class='alert alert-success'>Comment has been added</div>");

            $("#confirmAdd").attr('disabled', false);
            $("#confirmAdd").val('Add comment');

        });

    });
    $("#destroyNewComment").click(function (e) {
        console.log("asdsadasd");
            e.preventDefault();

            var id = $("#comment_id").val();
            var url = $("#delete_comment_url").val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('comment_id')
                }
            });

            var req = $.ajax({
                        method: "POST",
                        url: url,
                        data: {id: id},

                    }
            );
            console.log(id);

    });

</script>
@endpush
