@extends('layouts.admin')
@section('title', 'Edit Thana')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Thana</span>
    </div>
    <form action="{{route('thana.update',$thana->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class=""><i class="fas fa-cogs me-1"></i>Edit Thana</div>
                    </div>
                    <div class="card-body table-card-body">
                        <div class="row">
                            <div class="col-md-3 pb-2">
                                <strong><label>  Select District </label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-9 pb-2">  
                                     <select name="district_id" id="district_id" class="js-example-basic-multiple form-control my-select my-form-control">
                                     @foreach ($district as $item)
                                         <option value="{{$item->id}}" {{$item->id == $thana->district_id?'selected':''}}>{{$item->name}}</option>
                                     @endforeach
                                    </select>   
                            </div>

                            <div class="col-md-3">
                                <strong><label>Area Name</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-9">
                                <input type="text" value="{{$thana->name}}" class="form-control  @error('name') is-invalid @enderror " name="name" >
                            </div>
                            @error('name')
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