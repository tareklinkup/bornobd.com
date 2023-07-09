@extends('layouts.admin')
@section('title', 'Banner')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Banner</span>
    </div>
            <form id="bannerCreate" class="bannerCreate"  enctype="multipart/form-data">
               
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header py-1">
                                <div class="addT"><i class="fas fa-images me-1"></i>Add Banner</div>
                                <div class="updateT" style="display: none"><i class="fas fa-images me-1"></i>Update Banner</div>
                            </div>
                            <input type="hidden" id="id" name="id">
                                <div class="card-body table-card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong><label>Title</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-9">
                                          <input type="text" class="form-control my-form-control"  id="title"  name="title">
                                          <strong><span class="text-danger" id="titleError"></span></strong>
                                        </div>
                                        <div class="col-md-3">
                                            <strong><label>Short Details</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-9">
                                          {{-- <div class="form-control"  id="short_details"></div> --}}
                                          <textarea name="short_details" id="short_details" class="form-control"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                            <strong><label>Offer Name</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-9 mt-2">
                                          <input type="text" class="form-control my-form-control" id="offer_name" name="offer_name">
                                          <strong><span class="text-danger" id="offerError"></span></strong>
                                        </div>
                                        <div class="col-md-3">
                                            <strong><label>Offer Link</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-9">
                                          <input type="text" class="form-control my-form-control" id="offer_link" name="offer_link">
                                          <strong><span class="text-danger" id="offerlinkError"></span></strong>
                                        </div>
                                        <div class="col-md-3">
                                            <strong><label>Image</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-5 mt-2">
                                            <input type="file" class="form-control  my-form-control" id="image" name="image" onchange="readURL(this);">
                                            <span class="text-sm" style="font-size:11px;color:red">(Image dainmantion must be(1360*600))</span>
                                            <strong><span class="text-danger" id="imageError"></span></strong>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <img class="form-controlo img-thumbnail" src="#" id="previewImage" style="height:100px;width:120px; background: #3f4a49;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary btn-sm mt-2 float-right mt-3 btn-p" id="createBtn" onclick="addData()" value="Submit">Create</button>
                                            <button type="submit" class="btn btn-primary btn-sm mt-2 float-right mt-3 btn-p" id="updateBtn" style="display: none" value="Submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                        
                            
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="card"> 
                            <div class="card-header py-1">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Banner List <a href="#" class="btn btn-sm float-right"><i class="fas fa-print"></i></a></div>
                            </div>
                            <div class="card-body table-card-body p-3">
                                <table id="datatablesSimple">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th> Title</th>
                                            <th>Offer Name</th>
                                            <th>Offer Link</th>
                                            <th>Banner</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                      {{-- <tr>
                                          <td>T-shirt</td>
                                          <td>Furniture 50%</td>
                                          <td>http://linkuptechbd.com</td>
                                          <td>Details here</td>
                                          <td style="white-space: nowrap">
                                              <a class="btn btn-edit btn-info btn-sm"><i class="fas fa-edit"></i></a> 
                                              <a class="btn btn-delete btn-danger btn-sm"><i class="fas fa-trash"></i></a> 
                                          </td>
                                      </tr> --}}
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
<script src="{{ asset('admin/js/sweetalert2.all.js') }}"></script>
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
    // ajax header setup
     $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        // all data retrive from database
        function allData(){
            $.ajax({
                url:"{{route('banner.all')}}",
                type:"get",
                dataType: "json",
                success:function(res){
                    var data = "";
                    $.each(res,function(key,value){
                        data = data + '<tr>'
                        data = data + '<td>'+value.title+'</td>'
                        data = data + '<td>'+value.offer_name+'</td>'
                        data = data + '<td>'+value.offer_link+'</td>'
                        data = data + '<td><img src="/uploads/banner/'+value.image+'" style="width: 50px; height: 50px;"></td>'
                      
                        data = data + '<td class="text-nowrap text-center">'
                        data = data + '<a class="btn btn-edit btn-info btn-sm " id="createSubmit" onclick="editData('+value.id+')"><i class="fas fa-edit"></i></a>'
                        data = data + '<a class="btn btn-delete btn-danger btn-sm" onclick="deleteData('+value.id+')"><i class="fas fa-trash"></i></a>'
                        data = data + '</td>'
                    })
                    $('#tableBody').html(data);
                }
            })
        }
        allData();

       
        $(document).on('submit', '.bannerCreate', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            console.log(formData);
            $.ajax({
                url:"{{route('banner.store')}}",
                type:"post",
                dataType: "json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(res){
                    $('#bannerCreate').trigger('reset');
                    allData();
                    $('#short_details').val('');
                    $('#imagePreview').val('');
                    $('#previewImage').attr('src','/noimage.png');

                     // error messag hide
                    $('#titleError').text('');
                    $('#title').removeClass('is-invalid');
                    $('#short_details').removeClass('is-invalid');
                    $('#offerError').text('');
                    $('#offer_name').removeClass('is-invalid');
                    $('#offerlinkError').text('');
                    $('#offer_link').removeClass('is-invalid');
                    $('#imageError').text('');
                    $('#image').removeClass('is-invalid');
                },
                error:function(data){
                    $('#titleError').text(data.responseJSON.errors.title);
                    if(data.responseJSON.errors.title){
                        $('#title').addClass('is-invalid');
                    }
                    $('#offerError').text(data.responseJSON.errors.offer_name);
                    if(data.responseJSON.errors.offer_name){
                        $('#offer_name').addClass('is-invalid');
                    }
                    $('#offerlinkError').text(data.responseJSON.errors.offer_link);
                    if(data.responseJSON.errors.offer_link){
                        $('#offer_link').addClass('is-invalid');
                    }
                    $('#imageError').text(data.responseJSON.errors.image);
                    if(data.responseJSON.errors.image){
                        $('#image').addClass('is-invalid');
                    }
                }

            });
        })
        
        function editData(id){
            var url = "/website-content/banner/edit/"+id;
            console.log(url);
            $.ajax({
            url:url,
            type:"get",
            dataType:"json",
            success:function(res){
            // console.log(res)
              $('#createBtn').hide();
              $('#updateBtn').show();
              $('#title').val(res.title);
              $('#short_details').html(res.short_details);
              $('#offer_name').val(res.offer_name);
              $('#offer_link').val(res.offer_link);
              $('#previewImage').attr('src',res.image);
             
              $('#id').val(res.id);
              $('#bannerCreate').removeClass('bannerCreate');
              $('#bannerCreate').addClass('editCreate');
               // error messag hide
               $('#titleError').text('');
                    $('#title').removeClass('is-invalid');
                    $('#short_details').removeClass('is-invalid');
                    $('#offerError').text('');
                    $('#offer_name').removeClass('is-invalid');
                    $('#offerlinkError').text('');
                    $('#offer_link').removeClass('is-invalid');
                    $('#imageError').text('');
                    $('#image').removeClass('is-invalid');
            }
          })
        }
        // ajax update data
        $(document).on('submit', '.editCreate', function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url:"{{route('banner.update')}}",
                type:"post",
                dataType: "json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(res){
                    $('#bannerCreate').trigger('reset');
                    allData();
                    $('#short_details').val('');
                    $('#image').val('');
                     // error messag hide
                    $('#titleError').text('');
                    $('#title').removeClass('is-invalid');
                    $('#short_details').removeClass('is-invalid');
                    $('#offerError').text('');
                    $('#offer_name').removeClass('is-invalid');
                    $('#offerlinkError').text('');
                    $('#offer_link').removeClass('is-invalid');
                    $('#imageError').text('');
                    $('#image').removeClass('is-invalid');
                    $('#previewImage').attr('src','/noimage.png');
                   
                },
                error:function(data){
                    $('#titleError').text(data.responseJSON.errors.title);
                    if(data.responseJSON.errors.title){
                        $('#title').addClass('is-invalid');
                    }
                    $('#offerError').text(data.responseJSON.errors.offer_name);
                    if(data.responseJSON.errors.offer_name){
                        $('#offer_name').addClass('is-invalid');
                    }
                    $('#offerlinkError').text(data.responseJSON.errors.offer_link);
                    if(data.responseJSON.errors.offer_link){
                        $('#offer_link').addClass('is-invalid');
                    }
                    $('#imageError').text(data.responseJSON.errors.image);
                    if(data.responseJSON.errors.image){
                        $('#image').addClass('is-invalid');
                    }
                }

            });
        })

        function deleteData(id){
            console.log(id);
            
            var x = confirm("Are you sure you want to delete?");
                if (x)
                $.ajax({
                url:"/website-content/banner/delete/"+id,
                    type:"get",
                    dataType:"json",
                    success:function(res){
                        allData();
                        setInterval('refreshPage()', 5000);
                    }
                });   
        }
            
</script>
@endpush