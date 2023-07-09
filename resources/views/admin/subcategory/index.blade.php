@extends('layouts.admin')
@section('title', 'subsubcategory')
@section('admin-content')
@push('admin-css')
  <style>
    #preview img{
      margin:5px;
    }
  </style>
  @endpush
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Input Group</span>
    </div>
       <div class="row">
           <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <div class="table-head"><i class="fas fa-cogs me-1"></i>subsubcategory Form</div>
                    </div>
                        <div class="card-body table-card-body p-3">
                          {{-- @if (Session('duplicate'))
                              <div class="alert alert-warning">
                                  <span>This sub Category Already taken</span>
                              </div>
                          @endif --}}
                        <form action="{{ route('subcategory.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 ">
                                    <label for="name">Category Name<span class="text-danger">*</span> </label>
                                    <select name="category_id" class="form-control form-control-sm @error('category_id') is-invalid @enderror">
                                        <option value="">------Select Category-------</option>
                                        @foreach ($category as $item)
                                            <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach 
                                    </select>
                                        @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The Category field is required.</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="col-md-12">
                                    <label for="name">Name<span class="text-danger">*</span> </label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-sm shadow-none @error('name') is-invalid @enderror" id="name" placeholder="Enter name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class="col-md-12 mb-2 vertical-file">
                                    <label for="image vertical-file"> Image</label>
                                    <input type="file" class="form-control " id="image" type="file" name="image" onchange="readURL(this);">
                                            @error('image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    <div class="form-group mb-0 mt-2">
                                        <img class="form-controlo img-thumbnail" src="#" id="previewImage" style="width: 100px;height: 80px; background: #3f4a49;">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>  
                    </div> 
                </div>
            </div>
             <div class="col-6">
               <div class="card"> 
                <div class="card-header">
                    <div class="table-head"><i class="fas fa-table me-1"></i>subsubcategory List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                </div>
                <div class="card-body table-card-body p-3">
                    <table id="datatablesSimple">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>Category Name</th>
                                <th>Subcategory Name</th>
                                <th>image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subcategory as $item)
                            <tr>
                                <td>{{ $item->Category->name }}</td>
                                <td>{{ $item->name }}</td>
                                <td><img src="{{ asset($item->image) }}" class="tbl-image" alt=""></td>
                                <td>
                                    <a href="{{ route('subcategory.edit', $item->id) }}" class="btn btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="submit" class="btn btn-delete" onclick="deleteUser({{ $item->id }})"><i class="far fa-trash-alt"></i></button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('subcategory.destroy', $item) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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

    // sweet alert
    document.getElementById("previewImage").src="/noimage.png";
    function deleteUser(id) {
            swal({
                title: 'Are you sure?',
                text: "You want to Delete this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
</script> 

@endpush