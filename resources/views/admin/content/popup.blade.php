@extends('layouts.admin')
@section('title', 'Collection')
@section('admin-content')
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Active PopUp Add</span>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-user-plus"></i>
                    Welcome
                </div>
                <div class="card-body table-card-body p-3 mytablreadiconURLe-body">
                    <form action="{{ route('popup.update',$content) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row " style="align-item:center; justify-content:center">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label>PopUp Link</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" value="{{ $content->pop_up_title }}"
                                        name="pop_up_title" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label for="popStatus">PopUp Status</label>
                                </div>
                                <div class="col-md-12">
                                    {{-- <input id="popStatus" type="checkbox" value="{{ $content->pop_up_status }}"  name="pop_up_status"> --}}
                                    <input type="checkbox" name="pop_up_status"
                                    value="1"
                                    {{ $content->pop_up_status == '1' ? 'checked' : '' }}
                                    class="" id="">
                                </div>

                                <div class="col-md-12">
                                    <label>PopUp Icon</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="pop_up_icon" class="form-control" id="image"
                                        onchange="readiconURL(this);">
                                </div>
                                <div class="col-md-12">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage1"
                                        style="height:120px;width:140px; background: #3f4a49;">
                                </div>
                                <div class="col-md-12">
                                    <label>PopUp Image</label> <small>Image(640*640 px)</small>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="pop_up_image" class="form-control" id="image"
                                        onchange="readURL(this);">
                                </div>
                                <div class="col-md-12">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage"
                                        style="height:120px;width:140px; background: #3f4a49;">
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <button type="submit" class="btn btn-primary mt-2"
                                    value="Submit">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
@push('admin-js')
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage')
                        .attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        document.getElementById("previewImage").src = "{{ asset($content->pop_up_image) }}";

        function readiconURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage1')
                        .attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        document.getElementById("previewImage1").src = "{{ asset($content->pop_up_icon) }}";
    </script>
@endpush
