@extends('layouts.admin')
@section('title', 'Service')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Service</span>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class=""><i class="fas fa-cogs me-1"></i>Add Service</div>
                            </div>
                            <div class="card-body table-card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><strong>Title :</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                      <input type="text" class="form-control my-form-control" name="">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Short Details</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                      <div class="form-control" id="short_details"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label><strong>Details :</strong></label>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                      <div class="form-control" id="details"></div>
                                    </div>
                                    <div class="col-md-3">
                                        <label><strong>Image :</strong></label>
                                    </div>
                                    <div class="col-md-5 mt-2">
                                        <input type="file" class="form-control my-form-control" id="image" name="logo" onchange="readURL(this);">
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <img class="form-controlo img-thumbnail" src="#" id="previewImage" style="height:100px;width:120px; background: #3f4a49;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 mt-3 btn-p" value="Submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   
                    <div class="col-md-6">
                        <div class="card"> 
                            <div class="card-header">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Service List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                            </div>
                            <div class="card-body table-card-body p-3">
                                <table id="datatablesSimple">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Details</th>
                                            <th>image</th>
                                            <th width="20%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                          <td>T-shirt</td>
                                          <td>Furniture  sdfsdf sdf sdfsf</td>
                                          <td></td>
                                          <td class="text-center">
                                              <a class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a> 
                                              <a class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a> 
                                          </td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
    </div>
</main>        
@endsection
@push('admin-js')
<script src="{{ asset('admin/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#short_details' ) )
        .catch( error => {
            console.error( error );
        } );
        
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#details' ) )
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
                    .width(100); 
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage").src="/noimage.png";  
</script> 

@endpush