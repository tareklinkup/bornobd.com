@extends('layouts.admin')
@section('title', 'Edit Another Category')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Update Another Category</span>
    </div>
   <div class="row">
    <div class="col-lg-6 m-auto">
        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-cogs"></i>
                Update Another Category
            </div>
            <div class="card-body table-card-body p-3 mytable-body">
                <form action="{{ route('anotherCategory.update', $anotherCategory->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-4">
                                    <label for="name">Category Name<span class="text-danger">*</span> </label>
                                </div>
                               <div class="col-8">
                                <select name="category_id" class="form-control form-control-sm @error('category_id') is-invalid @enderror">
                                    <option value="">------Select Category-------</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $anotherCategory->category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach 
                                </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>The Category field is required.</strong>
                                        </span>
                                    @enderror
                               </div>
                                <div class="col-4">
                                    <label for="name">Sub Category Name<span class="text-danger">*</span> </label>
                                </div>
                               <div class="col-8">
                                <select name="sub_category_id" class="form-control form-control-sm @error('sub_category_id') is-invalid @enderror" id="sub_category_id">
                                    <option value="">------Select Category-------</option>
                                    @foreach ($subCategory as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $anotherCategory->sub_category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach 
                                </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>The Sub Category field is required.</strong>
                                        </span>
                                    @enderror
                               </div>
                                <div class="col-4">
                                    <label for="name">Sub Subcategory Name<span class="text-danger">*</span> </label>
                                </div>
                               <div class="col-8">
                                <select name="subsubcategory_id" class="form-control form-control-sm @error('subsubcategory_id') is-invalid @enderror" id="subsubcategory_id">
                                    <option value="">------Select Category-------</option>
                                    @foreach ($subsubcategory as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $anotherCategory->subsubcategory_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach 
                                </select>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>The Sub Subcategory field is required.</strong>
                                        </span>
                                    @enderror
                               </div>
                                <div class="col-md-4">
                                    <label>Another Category Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" value="{{ $anotherCategory->name }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary float-right btn-sm mt-2" value="Submit">Update</button>
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
<script>
    $(document).ready(function() {
        $("select[name='category_id']").on('change', function() {
            var category_id = $(this).val();
            $.ajax({
                url: "{{ url('product/subcategory/list') }}/" + category_id,
                dataType: "json",
                method: "GET",
                success: function(data) {
                    $('#sub_category_id').empty();
                    $.each(data, function(key, value) {
                        $('#sub_category_id').append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                }
            });

        });
    });

    $(document).ready(function() {
        $("select[name='sub_category_id']").on('change', function() {
            var sub_category_id = $(this).val();
            $.ajax({
                url: location.origin + "/product/subsubcategory/list/" + sub_category_id,
                dataType: 'JSON',
                method: 'GET',
                beforeSend: () => {
                    $('#subsubcategory_id').html("");
                },
                success: function(data) {
                    // console.log(data);
                    $('#subsubcategory_id').empty();
                    $.each(data, function(key, value) {
                        $('#subsubcategory_id').append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                }
            });

        });
    });
</script>

@endpush

