@extends('layouts.admin')
@section('title', 'Edit Partner')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> > Partner Update</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-cogs"></i>
            Update Partner
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            <form action="{{ route('partner.update', $partner->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <label> Name</label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="name" value="{{ $partner->name }}" class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label> Details</label>
                            </div>
                            <div class="col-md-9">
                                <textarea name="details"  class="form-control form-control-sm shadow-none @error('details') is-invalid @enderror" id="" cols="2" rows="4">{{ $partner->details }}</textarea>
                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="details_image">Inner Image</label>
                            </div>
                            <div class="col-md-9">
                                        <input type="file" class="form-control @error('details_image') is-invalid @enderror" id="details_image" type="file" size="100" name="details_image" onchange="readURL2(this);">
                                        <span style="color:red; font-size:12px"></span>
                                        @error('details_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                <div class="form-group mt-2 mb-2">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage2" style="width: 100px;height: 80px; background: #3f4a49;">
                                  
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Image </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" class="form-control" id="image" name="image" onchange="readURL(this);">
                                </div>
                                <div class="col-md-12 text-center mt-2">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage" style="height:120px;width:140px; background: #3f4a49;">
                                </div>
                            </div>
                            
                    </div>
                  
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-sm mt-2" value="Submit">Update</button>
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
            reader.onload=function(e) {
                $('#previewImage')
                    .attr('src', e.target.result)     
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage").src="{{ asset($partner->image) }}";
function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload=function(e) {
                $('#previewImage2')
                    .attr('src', e.target.result)     
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage2").src="{{ asset($partner->details_image) }}";
    
    
</script> 

@endpush