@extends('admin.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@stop
@section('content')
    <article class="content items-list-page">
        <p class="success-add"></p>
        <!--<p class="text-xs-center">All Items</p>-->

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>All Items - {{ $pictures->total() }}</h2>
                </div>
                <div class="pull-right">
                    <a class="btn btn-success" href="{{url('admin/add-item-form')}}"> Create New
                        Item</a>
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
                <th>Image</th>
                <th>BlackImage</th>
                <th>ForPainting</th>
                <th width="280px">Action</th>
            </tr>

            @foreach ($pictures as $picture)
            <tr>
                <td>{{ $picture->id }}</td>
                <td>
                    @if ($picture->image)
                    <img class="item-table-picture" src="/uploads/admin/image/{{ $picture->image}}"/>
                    @endif
                </td>
                <td>
                    @if ($picture->black_image)
                    <img class="item-table-picture" src="/uploads/admin/black_image/{{ $picture->black_image}}"/>
                    @endif
                </td>
                <td>
                    @if ($picture->for_painting)
                    <img class="item-table-picture" src="/uploads/admin/for_painting/{{ $picture->for_painting}}"/>
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="{{ url('/admin/add-show-item-page/') }}/{{ $picture->id }}">Show</a>
                    <a class="btn btn-primary"  href="{{ url('/admin/edit-item-page/') }}/{{ $picture->id }}">Edit</a>
                    <form method="get" action="{{  url('/admin/delete-item/') }}/{{ $picture->id }}" accept-charset="UTF-8" style="display:inline">
                        <input class="btn btn-danger" type="submit" value="Delete">
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {!! $pictures->links() !!}

    <!-- Trigger/Open The Modal -->
        <button class="myBtn" id="myBtn">Open Modal</button>

        <!-- The Modal -->
        <div  id="myModal"  class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span class="close">&times;</span>
                <p class="confirm-delete-question">Are you sure you want to delete item?</p>
                <div class="confirm-delete-buttons">
                    <button class="btn btn-info delete_item">OK</button>
                    <button class="btn btn-danger cancel_delete_item">Cancel</button>
                </div>
            </div>
        </div>


    </article>
    @endsection
    @section('script')
    <script>
        // Get the modal
        var modal = document.getElementById('myModal');
        var cancel_delete_item = document.getElementById('cancel_delete_item');

        // Get the button that opens the modal
        var btn = document.getElementsByClassName("myBtn")[0];

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }


        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        $(document).ready(function () {
            $(".dashboard").addClass('active');
        });

    </script>
    @endsection