@extends('layouts.app')
@section('content')
    @if(Auth::user()->access_level >= 3)
    <link rel="stylesheet" href="{{ URL::asset('css/categories.css') }}" />
    <div class="container">
        <div class="row">

            <div class="col-md-7 mt-5">

                <form action="{{ route('saveCategory') }}" method="POST" id="create_category_form">

                    <label for="title">Type category name</label>
                    <input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Category" name="category" maxlength="30" required><br>
                    {{ csrf_field() }}

                    <input type="submit" class="btn btn-primary" value="Create Category" id="create_cat">

                </form>
                <br>
                <div id="msg"></div>

                <br><br><br>
                    <label for="title">Manage existing category</label>


                <table class="table table-striped table-bordered" id="categories_list">

                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        @if(Auth::user()->access_level >= 5)
                        <th scope="col">Action</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->name}}</td>
                            @if(Auth::user()->access_level >= 5)
                            <td>
                                <span class="edit"><a href="{{ route('category_edit',['category_id' => $category->id ] ) }}">
                                        <img src="{{URL::asset('images/edit_logo.png')}}"  height="30" width="30" id="editCategory"/></a></span>&nbsp;
                                {{ Form::close() }}
                            {{ Form::open([ 'method'  => 'post', 'route' => [ 'category_delete', $category->id ], 'id'=>'id' ]) }}
                                    <span class="destroy">
                                        <input type="image" id="deleteCategory" onclick="return confirm('Are you sure you want delete this category? All posts in this category will be deleted.')" src="{{URL::asset('images/trash_logo.png')}}" height="20" width="20"/>
                                    </span>
                            {{ Form::close() }}
                            </td>
                            @endif
                        </tr>
                    @endforeach
                            </tbody>
                    </table>
                {{ $categories->links('') }}

            </div>
        </div>
    </div>
    @else
    You have no permission to see this
    @endif
@endsection

@push('scripts')
<script>
    $("#create_category_form").on('submit', function (e) {
        e.preventDefault();
        var name = $("#name").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var req = $.ajax({
                    method: "POST",
                    url: "{{ route('saveCategory') }}",
                    data: { name: name},
                    beforeSend: function (data) {
                        $("#create_cat").attr('disabled','disabled');
                        $("#create_cat").val('Please wait...');
                    }
                }
            );

        req.fail(function( data ) {

           var errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each( data.responseJSON.errors.name, function( key, value ) {
                errorsHtml += '<li>' + value + '</li>'; //showing only the first error.
            });
            errorsHtml += '</ul></div>';
            $( '#msg' ).html( errorsHtml );

            $("#create_cat").attr('disabled', false);
            $("#create_cat").val('Create Category');
        });

        req.done(function( data ) {
            var name = data.name;
            var id = data.id;
            var edit_url = '/wiki/public/categories/edit/'+id;
            var destroy_url = '/wiki/public/categories/delete/'+id;

            var newRow = "<tr><td>"+name+"</td>"
                    + "<td>"
                    + "<span class='edit'><a href='"+edit_url+"'><img src='{{URL::asset('images/edit_logo.png')}}'  height='30' width='30'/></a></span>"
                    + "<form method='post' action='"+destroy_url+"'> <input type='hidden' name='_token' value='{{ csrf_token() }}'>"
                    + "<span class='destroy'><input type='image' id='destroyComment' onclick='return confirm('Are you sure you want delete this comment?')' src='{{URL::asset('images/trash_logo.png')}}' height='20' width='20'/></span>"
                    + "</form>"
                    + "</tr></td>";

            $("#categories_list tbody").prepend(newRow);
            $("#name").val("");
            $("#msg").html("");
            $("#msg").html("<div class='alert alert-success'>Category has been created</div>");

            $("#create_cat").attr('disabled', false);
            $("#create_cat").val('Create Category');

        });

    });

</script>
@endpush

