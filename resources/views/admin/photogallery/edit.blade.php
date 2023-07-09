@extends('layouts.admin')
@section('title', 'Photo Gallery')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Photo Gallery</span>
    </div>
    <div class="card mb-3">
        
        <div class="card-body table-card-body p-3 mytable-body">
                <div class="row ">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class=""><i class="fas fa-image me-1"></i>Add Photo</div>
                            </div>
                            <div class="card-body table-card-body">
                            <form action="{{ route('photo-gallery.update', $gallery) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><strong>Gallery Title:</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="title" value="{{ $gallery->title }}" placeholder="Gallery Title" class="form-control my-form-control @error('title') is-invalid @enderror">
                                          @error('title')
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                          </span> 
                                        @enderror 
                                    </div>
                                    <div class="col-md-3">
                                        <label><strong>Select Photo: </strong></label>
                                    </div>
                                    <div class="col-md-5 mt-1">
                                        <input name="image" type="file" class="form-control form-control-sm @error('image') is-invalid @enderror" id="image" type="file"  onchange="readURL(this);">
                                          @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span> 
                                          @enderror
                                      </div>
                                      <div class="col-md-3 mt-1">
                                        <img class="form-controlo img-thumbnail" src="#" id="previewImage" style="width: 100px;height: 80px; background: #3f4a49;">
                                      </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-sm btn-primary float-right mt-2" value="Submit">upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>     
                    </div>   
                </div>
            </div> 
        </div>
    </main>        
@endsection
@push('admin-js')
<script src="{{ asset('admin/js/sweetalert2.all.js') }}"></script>
<script> 
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload=function(e) {
                $('#previewImage')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage").src="{{ asset($gallery->image) }}";
</script> 
@endpush