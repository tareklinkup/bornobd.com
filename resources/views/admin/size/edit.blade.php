@extends('layouts.admin')
@section('title', 'Size Edit')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Size</span>
    </div>
    <form action="{{route('size.update',$size->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class=""><i class="fas fa-camera fa-xs me-1"></i>Edit Size</div>
                    </div>
                    <div class="card-body table-card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong><label>Size Name</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="{{$size->name}}" class="form-control  @error('name') is-invalid @enderror " name="name" >
                            </div>
                            @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
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