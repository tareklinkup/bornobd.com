@extends('layouts.admin')
@section('title', 'Country')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Country</span>
    </div>
    
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <form action="{{route('country.update',$country)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="card-header">
                                    <div class=""><i class="fas fa-cogs me-1"></i>Add Country</div>
                                </div>
                                <div class="card-body table-card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong><label>Code</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-9">
                                        <input type="text"  class="form-control my-form-control @error('code') is-invalid @enderror" name="code">
                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <strong><label>Name</label> <span class="float-right">:</span></strong>
                                        </div>
                                        <div class="col-md-9">
                                        <input type="text" class="form-control my-form-control @error('name') is-invalid @enderror" name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button type="submit" class="btn btn-primary float-right mt-2" value="Submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                   
                    
                </div>
           
    </div>
</main>        
@endsection
@push('admin-js')
@endpush