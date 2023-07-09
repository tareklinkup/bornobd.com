@extends('layouts.admin')
@section('title', 'Another Category')
@section('admin-content')
    @push('admin-css')
        <style>
            #preview img {
                margin: 5px;
            }
        </style>
    @endpush
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Another
                    Category</span>
            </div>
            <div class="row">
                <div class="col-6 m-auto">
                    <div class="card">
                        <div class="card-header">
                            <div class="table-head"><i class="fas fa-cogs me-1"></i>Another Category Form</div>
                        </div>
                        <div class="card-body table-card-body p-3">
                            {{-- @if (Session('duplicate'))
                              <div class="alert alert-warning">
                                  <span>This sub Category Already taken</span>
                              </div>
                          @endif --}}
                            <form action="{{ route('anotherCategory.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <label for="name">Category Name<span class="text-danger">*</span> </label>
                                        <select name="category_id"
                                            class="form-control form-control-sm @error('category_id') is-invalid @enderror">
                                            <option value="">------Select Category-------</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The Category field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 ">
                                        <label for="name">Subcategory Name<span class="text-danger">*</span> </label>
                                        <select name="sub_category_id"
                                            class="form-control form-control-sm @error('sub_category_id') is-invalid @enderror"
                                            id="sub_category_id">
                                            <option value="">---Select Subcategory---</option>=
                                            @foreach ($SubCategory as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('sub_category_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The sub category field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 ">
                                        <label for="name">Sub Subcategory Name<span class="text-danger">*</span> </label>
                                        <select name="subsubcategory_id"
                                            class="form-control form-control-sm @error('subsubcategory_id') is-invalid @enderror"
                                            id="subsubcategory_id">
                                            <option value="">---Select Sub Subcategory---</option>=
                                            @foreach ($SubsubCategory as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('subsubcategory_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('subsubcategory_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>The sub subcategory field is required.</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="name">Name<span class="text-danger">*</span> </label>
                                        <input type="text" name="name" value="{{ old('name') }}"
                                            class="form-control form-control-sm shadow-none @error('name') is-invalid @enderror"
                                            id="name" placeholder="Enter name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="table-head"><i class="fas fa-table me-1"></i>Another Category List <a href=""
                                    class="float-right"><i class="fas fa-print"></i></a></div>
                        </div>
                        <div class="card-body table-card-body p-3">
                            <table id="datatablesSimple">
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Subcategory Name</th>
                                        <th>Sub Subcategory Name</th>
                                        <th>Another Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anotherCategory as $item)
                                        <tr>
                                            <td>{{ optional($item->Category)->name }}</td>
                                            <td>{{ optional($item->SubCategory)->name }}</td>
                                            <td>{{ optional($item->subSubCategory)->name }}</td>
                                            <td>{{ $item->name }}</td>

                                            <td>
                                                <a href="{{ route('anotherCategory.edit', $item->id) }}"
                                                    class="btn btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                                <button type="submit" class="btn btn-delete"
                                                    onclick="deleteUser({{ $item->id }})"><i
                                                        class="far fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('anotherCategory.delete', $item) }}" method="POST"
                                                    style="display: none;">
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
    <script>
        $(document).ready(function() {
            $("select[name='category_id']").on('change', function() {
                var category_id = $(this).val();
                $.ajax({
                    url: "{{ url('/product/subcategory/list') }}/" + category_id,
                    dataType: "json",
                    method: "GET",
                    success: function(data) {
                        console.log(data);
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
