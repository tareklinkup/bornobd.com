@extends('layouts.admin')
@section('title', 'Order Record')
@section('admin-content')
    <main>
        <div class="container">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Order Record</span>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="table-head text-left"><i class="fas fa-table me-1"></i>Order Record <a href=""
                            class="float-right"><i class="fas fa-print"></i></a></div>
                </div>
                <div class="card-body">

                    <form action="{{ route('order.record.search') }}" method="get">
                        <div class="row">
                            
                            <div class="col-3">
                               <select name="product_id" id="" class="form-control js-example-basic-multiple">
                                   <option value="">Select Product</option>
                                   @foreach ($product as $item)
                                   <option value="{{$item->id}}">{{$item->name}}</option>
                                   @endforeach
                               </select>
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" name="start_date" value="<?php echo date('Y-m-d'); ?>"  class="form-control @error('start_date') is-invalid @enderror">
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" name="end_date" value="<?php echo date('Y-m-d'); ?>" class="form-control @error('end_date') is-invalid @enderror">
                                @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                            </div>
                            <div class="col-3">
                                <button class="btn  btn-primary btn-sm" type="submit">search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body table-card-body p-3">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="home-tab">
                            <table id="first_table">
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th class="text-nowrap">SL</th>
                                        <th class="text-nowrap">Order ID</th>
                                        <th class="text-nowrap">Product Name</th>
                                        <th class="text-nowrap">Quantity</th>
                                        <th class="text-nowrap">Customer Name</th>
                                       
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                 @if(isset($orderDetails))
                                    @foreach ($orderDetails as $key=> $item)
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$item->order_id}}</td>
                                    <td>{{$item->product_name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>{{$item->order->customer_name}}</td>
                                    
                                </tr>
                                     @endforeach
                                  
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
