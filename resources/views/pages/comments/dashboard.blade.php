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
        <table class="table table-bordered">
            <tr>
                <th>No </th>
                <th>Author/User Name</th>
                <th>Author/User Email</th>
                <th>Description</th>
                <th>date</th>
                {{--<th width="280px">Comments</th>--}}
            </tr>
            @foreach ($comments as $comment)
                <tr>
                    <td>{{ $comment->user->id }}</td>

                    <td>{{ $comment->user->name }}</td>

                    <td>{{ $comment->user->email }}</td>

                    <td>
                        {{--<span>{{  htmlentities($comment->description, ENT_QUOTES | ENT_IGNORE, "UTF-8")}}  </span>--}}
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
            <input name="item_id" type="hidden" value=""/>

            <div class="form-group">
                <label for="comment">Type your Comment:</label>
                <textarea placeholder="Add Comment" class="form-control" rows="5" id="comment_area"
                          name="description"></textarea>
                <input name="add_comment" class="btn btn-success" type="submit" value="Add Comment">
            </div>
        </form>


    </article>
@endsection
@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="{{asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
    {{--<script src="{{asset('/vendor/unisharp/laravel-ckeditor//adapters/jquery.js')}}"></script>--}}


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


        $(document).ready(function () {
            CKEDITOR.replace('comment_area');
            $(".dashboard").addClass('active');
        });
    </script>
@endsection