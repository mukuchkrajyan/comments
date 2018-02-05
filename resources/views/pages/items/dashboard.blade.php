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
                    <h2>All Items - {{ $items->total() }}</h2>
                </div>


                <div class="pull-right">
                    <label for="sel1">Items per page:</label>
                    <select class="form-control" id="sel1">
                        @for ($i =1; $i <= 10; $i++)
                            @if($per_page == $i)
                                <option selected value="{{ $i }}">{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                    <a disabled class="btn btn-success"> Create New Item</a>
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
                <th>No</th>
                <th>Title</th>
                <th>Description</th>
                <th width="280px">Comments</th>
            </tr>

            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>
                        @if ($item->title)
                            <span>{{ $item->title}} </span>
                        @endif
                    </td>
                    <td>
                        @if ($item->description)
                            <span>{{ $item->description}} </span>
                        @endif
                    </td>

                    <td>
                        <a class="btn btn-info"
                           href="{{ url('/comments/') }}/{{ $item->id }}">Comment</a>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $items->links() !!}

    </article>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

@section('script')
    <script>
        $(document).ready(function () {

            @if ($per_page)
                per_page = '{{ $per_page }}';
            $("li a").attr('href', function () {
                a = $(this).attr('href') + '&per_page=' + per_page;
                return a;
            });
            @endif

            $("#sel1").change(function () {
                if (window.location.href.indexOf('per_page=') == -1) {
                    alert(1);
                    new_url = window.location.href + '?per_page=' + $(this).val();
                }
                else {
                    new_url = window.location.href.slice(0, -1) + $(this).val();
                }
                window.location.href = new_url;
            });
        });
    </script>
@endsection