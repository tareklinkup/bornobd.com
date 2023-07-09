@extends('layouts.admin')
@section('title', 'All Order')
@section('admin-content')
<main>
    <div class="container">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Order List</span>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="table-head text-left"><i class="fas fa-table me-1"></i>Pending Order List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                
            </div>
            <div class="card-body table-card-body p-3">
                <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="home-tab">
                       <table id="first_table">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Customer Id</th>
                                <!--<th>Delivery Date & Time</th>-->
                                <th>Customer Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       <tbody>
                        {{-- date('Y-m-d',strtotime($r->effective_date)); --}}
                            @foreach($orders as $key=> $order)
                            <tr class="text-center">
                                <td>{{$key+1}}</td>
                                <td>{{date('d M Y',strtotime($order->created_at))}}</td>
                                <td>@if(isset($order->customer->code)){{$order->customer->code}}@endif</td>
                                <!--<td>@if(isset($order->delivery_date)){{ $order->delivery_date}} @endif ,@if(isset($order->deliveryTime->time)) {{$order->deliveryTime->time}} @endif</td>-->
                                <td>@if(isset($order->customer_name)){{$order->customer_name}}@endif</td>
                                <td>{{$order->total_amount}}</td>
                                <td>
                                    @if ($order->status == 'p')
                                    <a href="{{route('order.pending',$order->id)}}" onclick="return confirm('Are you sure you want to process this order?');" class="btn btn-edit">Pending</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!--<a href="{{route('invoice.admin',$order->id)}}" class="btn btn-edit" title="View"><i class="fas fa-eye"></i></a>-->
                                    <!--<a href="{{route('order.details.edit',$order->id)}}" class="btn btn-edit" title="Edit"><i class="fas fa-edit"></i></a>-->
                                   
                                   <form action="{{route('product.order.delete',$order->id)}}" method="post">
                                        @csrf
                                        <a href="{{route('invoice.admin',$order->id)}}" class="btn btn-edit"><i class="fas fa-eye"></i></a>
                                        <a href="{{route('order.details.edit',$order->id)}}" class="btn btn-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                        <button href="" type="submit" class="btn btn-delete" title="Cancel" onclick="return confirm('Are you sure you want to cancel this order?');"><i class="fas fa-window-close"></i></button>
                                    </form>
                                   
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                  </div>
                 
            </div>
        </div>
    </div>
@endsection
