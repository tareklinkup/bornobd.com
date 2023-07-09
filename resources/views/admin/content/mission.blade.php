@extends('layouts.admin')
@section('title', 'Mission & Vission')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Mission & Vission</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            Welcome
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            <form action="{{route('mission.update',$company)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    
                    <div class="col-md-3">
                        <label>Mission Vission Title</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" value="{{$company->mission_vision_title}}" name="mission_vision_title" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Mission Vission Description</label>
                    </div>
                    <div class="col-md-9">
                        {{-- <div class="form-control" id="editor">
                        </div> --}}
                        <textarea name="mission_vision" id="editor" rows="10" class="form-control">
                            {!! $company->mission_vision !!}
                        </textarea>
                    </div>
                    <div class="col-md-3  mt-2">
                        <label>Term's & Condition Title</label>
                    </div>
                    <div class="col-md-9 mt-2">
                        <input type="text" value="{{$company->trams_condition_title}}" name="trams_condition_title" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Term's & Condition Description</label>
                    </div>
                    <div class="col-md-9">
                        {{-- <div class="form-control" id="condition">
                        </div> --}}
                        <textarea name="trams_condition" id="condition" class="form-control">
                            {!! $company->trams_condition !!}
                        </textarea>
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
{{-- <script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script> --}}
<script src="{{ asset('admin/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#condition' ) )
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
    document.getElementById("previewImage").src="/noimage.png";
    
</script> 

@endpush