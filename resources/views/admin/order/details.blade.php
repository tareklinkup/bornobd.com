@extends('layouts.admin')
@section('title', 'Product Order Details')
@section('admin-content')
<main>
    <div class="container">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Product Order Details</span>
        </div>
        <div class="card">
            <div class="card-header">
                <table class="table" style="background: #fff">
                    <thead class="text-center order-table">
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Color </th>
                            <th>Size</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($orderDetails as $key=> $d_order)
                            <form action="{{route('order.edit',$d_order->id)}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" id="{{$orderDetails['0']->order->id}}" value="{{$orderDetails['0']->order->id}}" >
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$d_order->product->name}}</td>
                                    <td>
                                        <input id=demoInput name="quantity" type='number' min='1'  max='110' value="{{$d_order->quantity}}" >
                                    </td>
                                    <td>
                                        <select name="color_id" id="color_id" class=" form-control  mr-2" data-live-search="true">
                                            <option value="">Select Color</option>
                                            @foreach ($colors as $color)
                                                <option value="{{$color->id}}" {{ $color->id == $d_order->color_id ? 'selected' : '' }}>{{$color->name}}</option>  
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="size_id" id="size" class=" form-control  mr-2" data-live-search="true" >
                                            <option value="">Select Size</option>
                                            @foreach ($sizes as $size)
                                                <option value="{{$size->id}}" {{ $size->id == $d_order->size_id ? 'selected' : '' }}>{{$size->name}}</option>  
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{$d_order->total_price}} </td>
                                    <td>
                                        <button type="submit" class="btn btn-edit mr-1" title="Save"><i class="fas fa-save"></i></button>
                                        <a href="{{route('order.cancel',$d_order->id)}}" title="Delete" onclick="return confirm('Are you sure! Delete this data')" class="btn btn-delete" ><i class="fas fa-trash"></i></a>
                                     </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('admin-js')

 <script src="{{ asset('admin/js/sweetalert2.all.js') }}"></script>
 <script>
      $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
       
 </script>

@endpush
