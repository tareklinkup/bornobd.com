@extends('layouts.admin')
@section('title', 'Admin Phone Number')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Edit Admin Mobile Number</span>
    </div>
    <form action="{{route('admin.phone.update')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class=""><i class="fas fa-cogs me-1"></i>Edit Admin Mobile Number</div>
                    </div>
                    <div class="card-body table-card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <strong><label>Admin Phone Number 1</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-7">
                                <input type="text" value="{{$content->phone_3}}" class="form-control  @error('phone_3') is-invalid @enderror " name="phone_3" >
                            </div>
                            @error('phone_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <strong><label>Admin Phone Number 2</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-7">
                                <input type="text" value="{{$content->phone_4}}" class="form-control  @error('phone_3') is-invalid @enderror " name="phone_4" >
                            </div>
                            @error('phone_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <strong><label>Admin Phone Number 3</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-7">
                                <input type="text" value="{{$content->phone_5}}" class="form-control  @error('phone_3') is-invalid @enderror " name="phone_5" >
                            </div>
                            @error('phone_3')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-primary mt-2" value="Submit">Update</button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>   
        </div>
        </form> 
    </div>
</main>        
@endsection
@push('admin-js')
@endpush