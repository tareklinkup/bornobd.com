@extends('layouts.admin')
@section('title', 'All Order')
@section('admin-content')
@push('admin-css')
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/all.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/css/invoice.css')}}">
@endpush
<main>
    <div class="container">
        <div id="printArea">
            <section class="top-header mt-5 company-header" style="display: none">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-6">
                            <div class="header-img">
                            <img src="{{asset('admin/images/link-up_technology.png')}}" alt="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 d-flex justify-content-end">
                        <div class="header-right">
                            <p class="header-address m-0"> <i class="fas fa-map-marker-alt"></i> <span>Plot:16(3rd Floor), Road:01</span></p>
                            <p class="header-phon m-0"> <i class="fas fa-phone"></i> <span>+8801911-978897</span></p>
                            <p class="header-email m-0"> <i class="fas fa-globe"></i> <span>mail@linktechbd.com</span></p>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="invoice-text">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <h1 class="text-center">Invoice</h1>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-6">
                        <div class="invoice-left">
                            <p class="m-0">Customer Id : <span>{{$orderDetails['0']->order->customer->code}}</span></p>
                            <p class="m-0">Customer Name : <span>{{$orderDetails['0']->order->customer->name}}</span></p>
                            <p class="m-0">Customer Address : {{$orderDetails['0']->order->customer->address}}<span></span> </p>
                            <p class="m-0">Customer Mobile : {{$orderDetails['0']->order->customer->phone}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-6 d-flex justify-content-end">
                        <div class="invoice-right">
                        <p class="m-0">Invoice Number : <span>{{$orderDetails['0']->order->invoice_no}}</span></p>
                        <p class="m-0">Date : <span>{{date('d M Y',strtotime($orderDetails['0']->order->created_at))}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
            </section>
            <section class="main-table mt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                        <div class="invoice-header">
                        <table class="invoice-table">
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </tr>
                            @isset($orderDetails)
                                @foreach ($orderDetails as $key=>$d_order)
                                    <tr style="text-align:center">
                                        <td>{{$key+1}}</td>
                                        <td>{{$d_order->product->name}}</td>
                                        
                                        <td>{{$d_order->quantity}}</td>
                                        <td>{{$d_order->price}}</td>
                                        <td>{{$d_order->price * $d_order->quantity }}</td>
                                    </tr>  
                                @endforeach
                            @endisset
                        </table>
                        </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="section-payment mt-3">
                <div class="container">
                  <div class="row">
                      <div class="col-lg-6 col-md-6 col-6">
                           <div class="">
                             <p class="word-text m-0">In Word : <span>Two thousand taka only</span></p>
                             <p class="payment-info m-0">Payment Info : <span>Cash On Delivery</span></p>
                             <p class="important-note m-0">Important : <span>Please Read "the Return Policy"</span></p>
                           </div>
                           <div class="short-note mt-3">
                               <p class="m-0">Note</p>
                               <div class="note-text-area">
                                  <textarea name="" class="note-area" cols="30" rows="2"></textarea>
                               </div>
                           </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-6">
                        <div class="paymet-option">
                          <p class="subtotal mb-0">Subtotal:<span class="span-subtotal">{{$orderDetails['0']->order->total_amount}} TK</span></p>
                          <p class="discout-amout mb-0">Discout:<span class="discout-percent"> 5%</span></p>
                          <p class="shipppping-cost mb-0">Shipping Cost:<span>200 Tk</span></p>
                          <p class="total-amout mb-0">Total Amount:<span class="span-amout">4000 Tk</span></p>
                          <p class="paid-amout mb-0">Paid:<span class="paid-span">1000 Tk</span></p>
                          <p class="due-amout mb-0">Due:<span class="paid-span">3000 Tk</span></p>
                        
                        </div>
                      </div>
                  </div>
               </div>
              </section>
            <br/>
            <br/>
        </div>

        <button class="btn btn-edit float-right mr-3" id="btnPrint"><i class="fas fa-print"></i></button>
        <br/>
        <br/>
        <br/>
        
    </div>
@endsection
@push('admin-js')
<script src="{{asset('admin/js/all.min.js')}}"></script>
<script>
    $("#btnPrint").on('click', function(){
        $('.company-header').css('display','block');
        var toPrint = document.getElementById('printArea');
    
    window.print();
    
});
</script>
@endpush