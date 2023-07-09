@extends('layouts.website');
@section('website-content')        
  <div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-wrap">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Customer Invoice</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
      <div class="row">
          <div class="col-lg-12">
              <div class="card mb-3 px-2">
                  <div class="card-body">
                      <div class="container-fluid">
                        <h3 class="text-right my-3">Invoice&nbsp;&nbsp;#{{ $order->invoice_no }}</h3>
                        <hr class="mt-1 mb-1">
                      </div>
                      <div class="container-fluid d-flex justify-content-between">
                        <div class="col-lg-3 pl-0">
                          <p class="mt-2 mb-2"><b>{{ $content->company_name }}</b></p>
                          <p>{{ $content->address }}</p>
                        </div>
                        <div class="col-lg-3 pr-0">
                          <p class="mt-2 mb-2 text-right"><b>Invoice to</b></p>
                          <p class="text-right">{{ $order->customer_name }}<br><strong> Billing Address:</strong> {{ $order->billing_address }}</p>
                          <p class="text-right">
                            @if ($order->billing_address != Null)
                              <strong> Shipping Address:</strong>    {{ $order->shipping_address }}
                            @else
                              
                            @endif
                        </p>
                        </div>
                      </div>
                      <div class="container-fluid d-flex justify-content-between mb-2">
                        <div class="col-lg-3 pl-0">
                          <p class="mb-0 mt-2">Invoice Date : {{ $order->created_at }}</p>
                         
                        </div>
                      </div>
                      <div class="container-fluid mt-2 d-flex justify-content-center w-100">
                        <div class="table-responsive w-100">
                            <table class="table">
                              <thead>
                                <tr class="bg-dark text-white">
                                    <th>#</th>
                                    <th>Description</th>
                                    <th class="text-right">Quantity</th>
                                    <th class="text-right">Unit cost</th>
                                    <th class="text-right">Total</th>
                                  </tr>
                              </thead>
                              <tbody>
                               
                                @foreach ($order->orderDetails as $key=> $item)
                                <tr class="text-right">
                                  <td class="text-center  p-1 t">{{ $key+1 }}</td>
                                  <td class="text-left p-1">{{ $item->product_name }}</td>
                                  <td class="p-1 ">{{ $item->quantity }} </td>
                                  <td class="p-1">{{ $item->price }} Tk</td>
                                  <td class="p-1">{{ $item->total_price }} Tk</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                      </div>
                      <div class="container-fluid mt-5 w-100">
                        {{-- <p class="text-right mb-2">Sub - Total amount: {{ $order }} Tk</p> --}}
                        <p class="text-right">Shipping : {{ $order->shipping_cost }} Tk</p>
                        <h4 class="text-right mb-5">Total : {{ $order->total_amount }} Tk</h4>
                        <hr>
                      </div>
                      <div class="container-fluid w-100">
                        <a href="#" class="btn btn-primary float-right mt-4 ml-2"><i class="fa fa-print mr-1"></i>Print</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection