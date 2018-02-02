@extends('admin.layouts.app')

@section('content')
    <article class="content items-list-page">

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p class="success-add">{{ $message }}</p>
            </div>
        @endif
             <p class="text-xs-center">Add Item</p>
            <div class="form-group">
                <div class="form-group">
                    <a href="{{ url('/admin/dashboard/')}}" class="btn btn-block btn-info">Back To Dashboard</a>
                </div>
            </div>
            <form enctype="multipart/form-data" id="add-item-form" novalidate="" class="form-horizontal" role="form" method="POST"
                  action="{{ url('/admin/add-item/') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                    <label for="image">Image</label>
                    <input id="image" type="file" class="form-control underlined" name="image"
                           value="{{ old('image') }}" placeholder="Image"    >
                    <img class="hidden-preview-images" id="imagePreview" src="#" alt="your image" />

                    @if ($errors->has('image'))
                        <span class="help-block">
                                        <strong class="err-field">{{ $errors->first('image') }}</strong>
                                    </span>
                    @endif
                </div>


                <div class="form-group{{ $errors->has('black_image') ? ' has-error' : '' }}">
                    <label for="black_image">blackImage</label>
                    <input id="black_image" type="file" class="form-control underlined" name="black_image"
                           value="{{ old('black_image') }}" placeholder="blackImage"    >
                    <img class="hidden-preview-images" id="black_image_preview" src="#" alt="your blackImage" />
                    @if ($errors->has('black_image'))
                        <span class="help-block">
                                        <strong class="err-field">{{ $errors->first('black_image') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('for_painting') ? ' has-error' : '' }}">
                    <label for="for_painting">forPainting</label>
                    <input id="for_painting" type="file" class="form-control underlined" name="for_painting"
                           value="{{ old('for_painting') }}" placeholder="Image"    >
                    <img class="hidden-preview-images" id="for_painting_preview" src="#" alt="your forPainting" />
                    @if ($errors->has('for_painting'))
                        <span class="help-block">
                                        <strong class="err-field">{{ $errors->first('for_painting') }}</strong>
                                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-primary">Add</button>
                    </div>
                </div>

            </form>
    </article>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(".add-itemn").addClass('active');

            $("#image").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = imageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
            $("#black_image").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = blackImageIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
            $("#for_painting").change(function () {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = forPaintingIsLoaded;
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });

        function imageIsLoaded(e) {
            $('#imagePreview').attr('src', e.target.result);
            $('#imagePreview').hide('fast');
            $('#imagePreview').show('slow');
        };
        function blackImageIsLoaded(e) {
            $('#black_image_preview').attr('src', e.target.result);
            $('#black_image_preview').hide('fast');
            $('#black_image_preview').show('slow');
        };
        function forPaintingIsLoaded(e) {
            $('#for_painting_preview').attr('src', e.target.result);
            $('#for_painting_preview').hide('fast');
            $('#for_painting_preview').show('slow');
        };
    </script>
@endsection