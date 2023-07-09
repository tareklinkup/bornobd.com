@extends('layouts.admin')
@section('title', 'Offer')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Offer</span>
    </div>
    <form action="{{route('offer.update',$offer)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class=""><i class="fas fa-cogs me-1"></i>Edit Offer</div>
                    </div>
                    <div class="card-body table-card-body">
                        <div class="row">
                            {{-- <div class="col-md-5">
                                <strong><label>Offer Limit Quantity </label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-7">
                                <input type="text" value="{{$offer->offer_limit_qty}}" class="form-control  @error('offer_limit_qty') is-invalid @enderror " name="offer_limit_qty" >
                            </div>
                            @error('offer_limit_qty')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror --}}
                            <div class="col-md-5">
                                <strong><label>Minimum Order Amount</label> <span class="float-right">:</span></strong>
                            </div>
                            <div class="col-md-7">
                                <input type="text" value="{{$offer->minimum_order_amount}}" class="form-control  @error('minimum_order_amount') is-invalid @enderror " name="minimum_order_amount" >
                            </div>
                            @error('minimum_order_amount')
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