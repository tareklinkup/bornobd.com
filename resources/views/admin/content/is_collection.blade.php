@extends('layouts.admin')
@section('title', 'Collection')
@section('admin-content')
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Active Collection</span>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fas fa-user-plus"></i>
                    Welcome
                </div>
                <div class="card-body table-card-body p-3 mytable-body">
                    <form action="{{ route('isCollection.update', $content) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <label>Collection Title</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" value="{{ $content->is_collection_title_1 }}"
                                        name="is_collection_title_1" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label>Collection Image</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="is_collection_img_1" class="form-control" id="image"
                                        onchange="readURL(this);">
                                </div>
                                <div class="col-md-12">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage"
                                        style="height:120px;width:140px; background: #3f4a49;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12  mt-2">
                                    <label>Collection Title</label>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <input type="text" value="{{ $content->is_collection_title_2 }}"
                                        name="is_collection_title_2" class="form-control">
                                </div>
                                <div class="col-md-12">
                                    <label>Collection Image</label>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="is_collection_img_2" class="form-control" id="image"
                                    onchange="readURL2(this);">
                                </div>
                                <div class="col-md-12">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage2"
                                        style="height:120px;width:140px; background: #3f4a49;">
                                </div>
                            </div>


                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mt-2 float-right"
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
        document.getElementById("previewImage").src = "{{ asset('uploads/collection/large/'.$content->is_collection_img_1) }}";

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage2')
                        .attr('src', e.target.result)
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        document.getElementById("previewImage2").src = "{{ asset('uploads/collection/large/'.$content->is_collection_img_2) }}";
    </script>
@endpush
