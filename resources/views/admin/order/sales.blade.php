@extends('layouts.admin')
@section('title', 'Sales Order')
@section('admin-content')
    <main>
        <div class="container">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Sales report</span>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="table-head text-left"><i class="fas fa-table me-1"></i>Sales Report <a href=""
                            class="float-right"><i class="fas fa-print"></i></a></div>
                </div>
                <div class="card-body">

                    <form action="{{ route('sales.report') }}" method="get">
                        <div class="row">
                            <div class="col-3">
                                <select class="form-control form-control-sm" name="type">
                                    <option value="2">Without Details</option>
                                    <option value="1">With Details</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="date" name="start_date" value="<?php echo $date_from; ?>"  class="form-control @error('start_date') is-invalid @enderror">
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                <input type="date" name="end_date" value="<?php echo $date_to; ?>" class="form-control @error('end_date') is-invalid @enderror">
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
                                        <th class="text-nowrap">Invoice Number</th>
                                        <th class="text-nowrap">Delivary Date</th>
                                        <th class="text-nowrap">Customer Id</th>
                                        <th class="text-nowrap">Customer Name</th>
                                        <th class="text-nowrap">Mobile No.</th>
                                        <th class="text-nowrap">Total Price</th>
                                        @if ($type == 1)
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th class="text-nowrap">Unit Price</th>
                                        <th>Subtotal</th>
                                        @endif
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                               
                                    {{-- {{ $search->orderDetails[0]->sum(price) }} --}}
                                    @if ($search->count() > 0)
                                        @if ($type == 1)
                                            @foreach ($search as $key => $order)
                                                <tr class="text-center">
                                                    <td>{{ $order->invoice_no }}</td>
                                                    <td>{{ date('d M Y', strtotime($order->updated_at)) }}</td>
                                                    <td>@if(isset($order->customer->code)){{$order->customer->code}}@endif</td>
                                                   <td>@if(isset($order->customer_name)){{$order->customer_name}}@endif</td>
                                                   <td>@if(isset($order->customer_mobile)){{$order->customer_mobile}}@endif</td>
                                                    <td class="text-right text-nowrap">{{ $order->total_amount }} Tk</td>
                                                    <td class="text-left p-1">{{ $order->orderDetails[0]->product_name }}</td>
                                                    <td class="p-1 text-center">
                                                        {{ $order->orderDetails[0]->quantity }} 
                                                       
                                                    </td>
                                                    <td class="p-1 text-right text-nowrap">
                                                        {{ $order->orderDetails[0]->price }} Tk</td>
                                                    <td class="p-1 text-right text-nowrap">{{ $order->orderDetails[0]->total_price }} Tk</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('invoice.admin', $order->id) }}"
                                                            class="btn btn-edit"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('order.cancel', $order->id) }}"
                                                            class="btn btn-delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                {{-- {{ $order->orderdetails }} --}}
                                                @if ($order->orderDetails->count() > 0)
                                                    @foreach ($order->orderDetails as $key => $item)
                                                        @if($loop->iteration != 1)
                                                            <tr>
                                                                <td colspan="6"></td>
                                                                <td class="text-left p-1">{{ $item->product_name }}</td>
                                                                <td class="p-1 text-center">
                                                                    {{ $item->quantity }} 
                                                                </td>
                                                                <td class="p-1 text-right text-nowrap">{{ $item->price }} Tk</td>
                                                                <td class="p-1 text-right text-nowrap">{{ $item->total_price }} Tk</td>
                                                                <td><td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                                <tr></tr>
                                            @endforeach
                                        @else
                                            @foreach ($search as $key => $order)
                                                <tr class="text-center">
                                                    <td>{{ $key + 1 }}</td>
                                                    {{-- <td>{{ date('d M Y', strtotime($order->created_at)) }}</td> --}}
                                                    <td>{{ date('d M Y', strtotime($order->updated_at)) }}</td>
                                                     <td>@if(isset($order->customer->code)){{$order->customer->code}}@endif</td>
                                                     <td>@if(isset($order->customer_name)){{$order->customer_name}}@endif</td>
                                                     <td>@if(isset($order->customer_mobile)){{$order->customer_mobile}}@endif</td>
                                                    <td colspan="text-right">{{ $order->total_amount }}</td>

                                                    <td class="text-center">
                                                        <a href="{{ route('invoice.admin', $order->id) }}"
                                                            class="btn btn-edit"><i class="fas fa-eye"></i></a>
                                                        <a href="{{ route('order.cancel', $order->id) }}"
                                                            class="btn btn-delete"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                           
                                        @endif
                                    @else
                                        <tr>
                                            <td class="w-100 text-center py-2" colspan="8">
                                                No Result Found
                                            </td>
                                        </tr>
                                    @endif
                                  
                                </tbody>
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th class="text-end" colspan="5">Total Delivery</th>
                                        <th class="text-nowrap text-start" colspan="2">= {{$total}}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
