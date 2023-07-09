@extends('layouts.admin')
@section('title', 'Edit Delivery Charge')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Edit Delivery Charge</span>
    </div>
    <form action="{{route('area.update',$delivery_charge->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class=""><i class="fas fa-cogs me-1"></i> Edit Delivery Charge</div>
                    </div>
                    <div class="card-body table-card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong><label>Area Name</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-8 mb-1">
                                <input type="text" class="form-control  @error('area') is-invalid @enderror " name="area" value="{{$delivery_charge->area}}" >
                            
                            @error('area')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            </div>
                            <div class="col-md-4">
                                <strong><label>Charge Amount</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-8">
                            <input type="text" value="{{$delivery_charge->charge}}" class="form-control  @error('charge') is-invalid @enderror " name="charge" placeholder="Charge Amount" >
                            @error('charge')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            </div>
                            
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
<script>
    $(document).ready(function() {
    $('#thana_id').select2();
});
</script>
@endpush