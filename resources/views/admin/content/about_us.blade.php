@extends('layouts.admin')
@section('title', 'About Us')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Welcome Content</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            Welcome
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            <form action="{{ route('about.update',$company) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-3">
                                <label>About Title Title</label>
                                
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="{{$company->about_title}}" name="about_title" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>Description </label>
                            </div>
                            <div class="col-md-9">
                                {{-- <div class="form-control" id="editor">
                                </div> --}}
                                <textarea name="about_description" class="form-control" id="editor" cols="30" rows="5">
                                    {!! $company->about_description !!}
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <label> Image </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="about_image" class="form-control" id="image" name="logo" onchange="readURL(this);">
                                </div>
                                <div class="col-md-12 text-center mt-2 ml-3">
                                    <img class="form-controlo img-thumbnail" src="#" id="previewImage" style="height:120px;width:140px; background: #3f4a49;">
                                </div>
                            </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mt-2 float-right" value="Submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
   </div>
      
    </div>
</main>        
@endsection
@push('admin-js')
<script src="{{ asset('admin/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
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
    document.getElementById("previewImage").src="{{asset($company->about_image)}}";
    
</script> 

@endpush