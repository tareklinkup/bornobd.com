@extends('layouts.website')
@section('title', 'Customer Invoice')
@section('website-content')
@push('admin-css')
<style>
  #printable{
    display: none !important;
  }
 @media print
  {
      /* #non-printable { display: none; }
      #printable { display: block !important; } 
      .card-border{
        border:none !important;
      }
      p{
        font-size: 25px;
      }
      th{
        font-size: 30px !important;
        color:#000 !important;
      }
      td{
        font-size: 25px !important;
      } */
  }
</style>
@endpush     
<div class="container">
    <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item fw-bold"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active fw-bolder" aria-current="page">User Invoice</li>
        </ol>
    </nav>
</div>
<div class="container">
  <div style=" margin: auto;" >
    <div class="row">
        <div class="col-xs-12">
            <div class="card mb-3 px-2" >
                <div class="card-body " id="printableArea">
                    <div>
                      <div style="display:flex">
                        <div class="logo-img" style="width: 50%">
                          <img src="{{asset($content->logo)}}" alt="logo" height="60px">
                        </div>
                        <div style="width: 50%">
                          <h3 style="text-align: right; margin:15px 0px;float:right">Invoice &nbsp;&nbsp;#{{ $order->invoice_no }}</h3>
                        </div>
                      </div>
                      
                      <hr class="mt-1 mb-1">
                    </div>
                    <div style="display: flex;width:100%">
                      <div style="width: 30%;">
                        <p class="mt-2 mb-2"><b>{{ $content->company_name }}</b></p>
                        <p>{{ $content->address }}</p>
                      </div>
                      <div style="width: 70%;">
                        <p style="text-align: right;"><b>Invoice to</b></p>
                        <p style="text-align: right; margin-bottom:0"><strong>Name: </strong>{{ $order->customer_name }}<br><strong>Phone:</strong> {{ $order->customer_mobile }}</p>
                        <!--<p style="text-align: right; margin-bottom:0">-->
                        <!--  <strong> Delivery Date : </strong> -->
                        <!--  @if(isset($order->delivery_date))-->
                        <!--    {{$order->delivery_date}}-->
                          
                        <!--  @endif-->
                         
                        
                        <!--</p>-->
                        <!--<p style="text-align: right; margin-bottom:0">-->
                        <!--  <strong> Delivery Time : </strong> -->
                        <!--  @if(isset($order->deliveryTime->time))-->
                        <!--  {{$order->deliveryTime->time}}-->
                        <!--  @endif-->
                        <!--</p>-->
                        <p style="text-align: right; margin-bottom:0">
                        <strong> Billing Address:</strong> {{ $order->billing_address }}</p>
                        <p style="text-align: right; margin-bottom:0">
                          @if ($order->shipping_address != Null)
                            <strong> Shipping Address:</strong>  {{ $order->shipping_address }}
                          @else
                          @endif
                      </p>
                      </div>
                    </div>
                    <div style="justify-content: space-between;">
                      <div class="col-xs-5 pl-0">
                        <p style="margin-bottom:5px">Invoice Date : {{ $order->created_at }}</p>
                      </div>
                    </div>
                    <div class="">
                          <table style="border-collapse: collapse;width: 100%;">
                            <thead style=" padding:10px;">
                              <tr >
                                  <th style="padding:10px;">#</th>
                                  <th style="padding:10px;text-align:left">Product Name</th>
                                  <th style="padding:10px; text-align:center">Quantity</th>
                                  <th style="text-align: right; padding:10px;">Unit cost</th>
                                  <th style="text-align: right; padding:10px;">Wrapping cost</th>
                                  <th style="text-align: right; padding:10px;">Trailoring cost</th>
                                  <th style="text-align: right; padding:10px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                              @foreach ($order->orderDetails as $key=> $item)
                              <tr style="text-align: right; ">
                                <td style="text-align: center; padding:5px; font-size:13px">{{ $key+1 }}</td>
                                <td style="text-align: left; padding:5px; font-size:13px">{{ $item->product_name }}</td>
                                <td  style="text-align:center; padding:5px; font-size:13px">{{ $item->quantity }} </td>
                                
                                <td style="text-align: right; padding:5px; font-size:13px">{{currency_sign()}} {{ currency_amount($item->price)}}</td>
                                <td style="text-align: right; padding:5px; font-size:13px">{{currency_sign()}} {{ currency_amount($item->wp_price)}}</td>
                                <td style="text-align: right; padding:5px; font-size:13px">{{currency_sign()}} {{ currency_amount($item->trailoring_charge)}}</td>
                                <td style="text-align: right; padding:5px; font-size:13px">{{currency_sign()}} {{ currency_amount($item->total_price)}}</td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        
                    </div>
                    <div>
                      <span id="word" ></span>
                     
                    {{-- <input id="number" type="hidden" value="{{ $order->total_amount }}" /> --}}
                      {{-- <p id="number"> Number: {{ $order->total_amount }} </p> --}}
                      <p  style="text-align: right;margin-bottom:0; margin-top:10px"><span style="font-weight:600">Sub Total :</span>{{currency_sign()}} {{ currency_amount($order->orderDetails->sum('total_price'))}} </p>
                      <p  style="text-align: right;margin-bottom:15px"><span style="font-weight:600;  ">Shipping :</span>{{currency_sign()}} {{ currency_amount( $order->shipping_cost)}} </p>
                      <h4 style="text-align: right; font-weight:700"><span>Total :</span><span id="number">{{currency_sign()}} {{ currency_amount( $order->total_amount)}}  </span></h4>
                      <hr >
                    </div>
                   
                </div>
                <div class="container-fluid w-100 mb-3" >
                  <button href="#"  onclick="printDiv('printableArea')" class="btn btn-primary btn-sm float-right ml-2"><i class="fa fa-print mr-1"></i>Print</button>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
@push('website-js')
      <script>
          function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
      }
      </script>

  @endpush