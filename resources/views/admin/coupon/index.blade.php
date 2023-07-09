@extends('layouts.admin')
@section('title', 'Coupon List')
@section('admin-content')
    @push('admin-css')
        <link rel="stylesheet" href="{{ asset('admin/css/jquery-ui.min.css') }}">
    @endpush
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Coupon</span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class=""><i class="fas fa-cogs me-1"></i>Add Coupon</div>
                        </div>
                        <div class="card-body table-card-body">
                            <form action="{{ route('coupon.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong><label>category</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" name="category_id" id="categoryId">
                                            <option class="form-control" value="">Select category</option>
                                            @foreach ($category as $item)
                                                <option class="form-control" value="{{ $item->id }}"  {{old('category_id') ==  $item->id ? 'selected' : ''  }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>SubCategory</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" name="sub_category_id" id="subcategoryID">
                                            <option class="form-control" value="">Select SubCategory</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Code</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="code" value="{{ old('code') }}" autocomplete="off" placeholder="Enter Promo Code" class="form-control  @error('code') is-invalid @enderror">
                                        @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <strong><label>Discount %</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="percent" placeholder="Enter Promo Discount %" value="{{ old('percent') }}" autocomplete="off"
                                            class="form-control  @error('percent') is-invalid @enderror">
                                        @error('percent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Start Date</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" name="start_date" value="{{ old('start_date') }}" placeholder="Enter Promo Start Date"  autocomplete="off"
                                            class="form-control  @error('start_date') is-invalid @enderror">
                                        @error('start_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Expiry Date</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" name="expiry_date" value="{{ old('expiry_date') }}" placeholder="Enter Promo Expiry Date"  autocomplete="off"
                                            class="form-control  @error('expiry_date') is-invalid @enderror ">
                                        @error('expiry_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 offset-md-3 mt-1">
                                        <button type="submit" class="btn btn-primary  btn-sm" value="Submit">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="table-head"><i class="fas fa-table me-1"></i>Coupon List <a href=""
                                    class="float-right"><i class="fas fa-print"></i></a></div>
                        </div>
                        <div class="card-body table-card-body p-3">
                            <table id="datatablesSimple" class="text-center">
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>Category</th>
                                        <th>Code</th>
                                        <th>Percent</th>
                                        <th>Start Date</th>
                                        <th>Expiry Date</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->category->name ?? '' }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->percent }}</td>
                                            <td>{{ $item->start_date }}</td>
                                            <td>{{ $item->expiry_date }}</td>
                                            <td>
                                                <a href="{{ route('coupon.edit', $item->id) }}"
                                                    class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></a>
                                                <button type="submit" class="btn btn-delete"
                                                    onclick="couponUser({{ $item->id }})"><i
                                                        class="far fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('coupon.destroy', $item->id) }}" method="POST"
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
    <script src="{{ asset('admin/js/jquery-ui.min.js') }}"></script>
    <script>
        $(document).on('change','#categoryId', function(e){
            event.preventDefault();
            var category_id = $('#categoryId').val();
            getSubcategory(category_id);
        });

        function getSubcategory(category_id){
            $.ajax({
                url:'{{ url("product/subcategory/list") }}/' + category_id,
                type: 'GET',
                dataType: 'JSON',
                success:function(response){
                    $('#subcategoryID').empty();
                    $.each(response, function(key, value){
                        $('#subcategoryID').append('<option value=" '+value.id+'">' +value.name+ '</option>');
                    });
                }
            })
        }
    </script>
    <script>

        function couponUser(id) {
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
