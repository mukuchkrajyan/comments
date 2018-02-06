@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@stop
@section('content')
    <article class="content items-list-page">
        <p class="success-add"></p>

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Current Item Comments - {{ $comments->count() }}</h2>
                </div>

            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <button id="new_comments_notify" type="button" class="btn btn-primary">There is/are N new comment(s). Click
            [here] to view. <span class="badge">0</span></button>
        </br>

        <table id="item_comments" class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Author/User Name</th>
                <th>Author/User Email</th>
                <th>Description</th>
                <th>date</th>
            </tr>
            @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->user->id }}</td>

                    <td>{{ $comment->user->name }}</td>

                    <td>{{ $comment->user->email }}</td>

                    <td>
                        <span>{{  htmlspecialchars_decode($comment->description) }}  </span>
                    </td>

                    <td>
                        <span>{{ $comment->date}} </span>
                    </td>

                </tr>
            @endforeach
        </table>
        {!! $comments->links() !!}
        <form action="{{url('comments/'.$item_id.'/add-comment')}}" method="POST">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <input name="user_id" type="hidden" value="{{ csrf_token() }}"/>
            <input readonly name="old_comments_count" id="old_comments_count" type="hidden"
                   value="{{$comments->count()}}"/>

            <div class="form-group">
                <label id="comment_label" for="comment">Type your Comment :
                    @if (Auth::check())
                    {{  Auth::user()->name}}
                    @endif

                </label>
                <textarea autofocus placeholder="Add Comment" class="form-control" rows="5" id="comment_area"
                          name="description"></textarea>
                <input id="add_comment" name="add_comment" class="btn btn-success" type="button" value="Add Comment">
            </div>
        </form>


    </article>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.editorConfig = function (config) {
            config.toolbar = [
                {name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
                {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                {
                    name: 'forms',
                    items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']
                },
                '/',
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']
                },
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {
                    name: 'insert',
                    items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']
                },
                '/',
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                {name: 'about', items: ['About']}
            ];
        };

        function commenntUpdate() {

            /*Getrting Item Comments count before request*/
            old_comments_count = $("#old_comments_count").val();

            $.post("{{url('comments/'.$item_id.'/get-comments-now/')}}", {

                _token: '{{ csrf_token() }}',

                old_comments_count: old_comments_count

            }, function (data) {

                new_comments_count = data.new_comments_count;

                new_comments = data.new_comments;

                new_added_comments_count = data.new_added_comments_count;

                new_added_comments = data.new_added_comments;

                $(".badge").text(new_added_comments_count);

                if (new_comments == true) {

                    $("#new_comments_notify").show('fast');

                    localStorage.setItem("new_added_comments", JSON.stringify(new_added_comments));

                    localStorage.setItem("new_comments_count", new_comments_count);


                }
            });
        }

        $(document).ready(function () {

            $(document).keyup(function (e) {
                if (e.keyCode == 13) {
//enter key
                }
            });


            $('#new_comments_notify').click(function (e) {

                new_comments_count = localStorage.new_comments_count;

                new_added_comments = localStorage.new_added_comments;

                new_added_comments_parsed = JSON.parse(new_added_comments);

                for (i = 0; i < new_added_comments_parsed.length; i++) {
                    new_added_comments_parsed_curr = new_added_comments_parsed[i];

                    commentid = new_added_comments_parsed_curr.commentid;

                    description = new_added_comments_parsed_curr.description;

                    email = new_added_comments_parsed_curr.user.email;

                    name = new_added_comments_parsed_curr.user.name;

                    date = new_added_comments_parsed_curr.date;

                    $("#item_comments>tbody").append("<tr style='display:none'><td>" + commentid + "</td> <td>" + name + "</td> <td>" + email + "</td><td>" + description + "</td><td> " + date + "</td></tr>");
                }

                $("#old_comments_count").val(new_comments_count);

                $(".badge").text(0);

                $("#new_comments_notify").hide('slow');

                $("#item_comments>tbody>tr").show('slow');


                $('html, body').animate({
                    scrollTop: $("#item_comments>tbody>tr:last").offset().top
                }, 1000);

            });
            $('#add_comment').click(function (e) {

                /*getting editor value*/
                commented_text = CKEDITOR.instances.comment_area.getData();

                $.post("{{url('comments/'.$item_id.'/add-comment')}}", {

                    ajax: 1,

                    description: commented_text,

                    _token: '{{ csrf_token() }}'

                }, function (data) {

                    id = data.id;

                    email = data.email;

                    description = data.description;

                    name = data.name;

                    date = data.date.date;

                    $("#item_comments>tbody").append("<tr style='display:none'><td>" + id + "</td> <td>" + name + "</td> <td>" + email + "</td><td>" + description + "</td><td> " + date + "</td></tr>");

                    $("#item_comments>tbody>tr").show('slow');

                });

                CKEDITOR.instances.comment_area.setData("");
                /*Resetting Editor value*/
            });

            setInterval('commenntUpdate()', 1500);

            CKEDITOR.replace('comment_area');
            /* Ckeditor set*/

        });
    </script>
@endsection