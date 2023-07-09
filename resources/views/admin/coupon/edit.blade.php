@extends('layouts.admin')
@section('title', 'Coupon List Edit')
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
                            <div class=""><i class="fas fa-cogs me-1"></i>Edit Coupon</div>
                        </div>
                        <div class="card-body table-card-body">
                            <form action="{{ route('coupon.update', $coupon->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong><label>Category</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" name="category_id" id="categoryId">
                                            <option class="form-control" value="">Select category</option>
                                            @foreach ($category as $item)
                                                <option class="form-control" value="{{ $item->id }}"  {{ $item->id == $coupon->category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>SubCategory</label> <span class="float-right">:</span></strong>
                                       {{-- {{ $coupon->sub_category_id }} --}}
                                    </div>
                                    <div class="col-md-9">
                                        <select class="form-control" name="sub_category_id" id="subcategoryID">
                                            {{-- <option class="form-control" value="{{ $coupon->sub_category_id }}" selected >{{ $coupon->sub_category_id }}</option> --}}
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Percent</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="percent" value="{{ $coupon->percent }}"
                                            class="form-control  @error('percent') is-invalid @enderror ">
                                        @error('percent')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Code</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="code" value="{{ $coupon->code }}"
                                            class="form-control  @error('code') is-invalid @enderror ">
                                        @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Start Date</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="date" name="start_date" value="{{ $coupon->start_date }}"
                                          
                                            class="form-control  @error('start_date') is-invalid @enderror ">
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
                                        <input type="date" name="expiry_date" value="{{ $coupon->expiry_date }}"
                                           
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
                                        <button type="submit" class="btn btn-primary btn-sm mt-2"
                                            value="Submit">Update</button>
                                    </div>
                                </div>
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
                                        <th>Code</th>
                                        <th>Start Date</th>
                                        <th>Expiry Date</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->start_date }}</td>
                                            <td>{{ $item->expiry_date }}</td>
                                            <td>
                                                <a href="{{ route('coupon.edit', $coupon->id) }}"
                                                    class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></a>
                                                <button type="submit" class="btn btn-delete"
                                                    onclick="couponUser({{ $coupon->id }})"><i
                                                        class="far fa-trash-alt"></i></button>
                                                <form id="delete-form-{{ $item->id }}"
                                                    action="{{ route('coupon.destroy', $coupon->id) }}" method="POST"
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
          $(document).ready(function(){
           $("select[name='category_id']").on('change', function(){
               var category_id =$(this).val();
               coupon(category_id)
           });
       });
       var categoryId = "<?php echo $coupon->category_id ?>";
       coupon(categoryId);
       function coupon(id) {
           var subcategoryId = id;
           if(subcategoryId != 0 && subcategoryId != undefined) {
               $.ajax({
                   url:"{{ url('product/subcategory/list')}}/"+ subcategoryId,
                   type :"GET",
                   dataType:"json",
                   success:function(data){
                    //    alert('ok')
                   $('#subcategoryID').empty();
                       $.each(data, function(key,value){
                           let value_id = value.id;
                           let selected = '';

                           if(value_id == '{{$coupon->sub_category_id}}'){
                            selected = 'selected';
                           }
                       $("#subcategoryID").append('<option value="'+value_id+'" '+selected+'>'+value.name+'</option>');
                       });
                   }
               });
           }
       }
    </script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
            $("#datepickers").datepicker();
        });
    </script>
@endpush
