@extends('layouts.admin')
@section('title', 'Enable SMS')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Enable SMS</span>
    </div>
    
               
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form action="#" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class=""><i class="fas fa-envelope me-1"></i>Enable SMS</div>
                            </div>
                            <div class="card-body table-card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong><label>Enable SMS</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="checkbox" id="vehicle1" name="vehicle1" value="Bike" class="sms-check" >
                                    </div>
                                    <div class="col-md-3 mt-2">
                                        <strong><label>API Key</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <input type="text" name="api_key" value="C00715481245885488524"  value="" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>URL</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" value="https://linkuptecbnd.com/sms" name="api_key" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Bulk URL</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" value="https://linkuptecbnd.com/smsapi" name="api_key" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Sender ID</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="api_key" value="LinkUpTech" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>SMS Type</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" value="UNICODE" name="api_key" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Sender Name</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" value="Link-Up Technology" name="api_key" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Sender Phone</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="phone" value="+8801911-978897" class="form-control">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 float-right" value="Submit">Save</button>
                                    </div>
                                </div>
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
<script> 
    $("#selectAll").click(function() {
  $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#selectAll").prop("checked", false);
  }
});

jackHarnerSig();
</script> 

@endpush