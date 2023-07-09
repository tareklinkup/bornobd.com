@extends('layouts.website')
@section('title', 'Cart List')
@section('website-content')

<section class="cart-section mt-3">
    <div class="custom-container">
        <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">Cart List</li>
            </ol>
        </nav>
        <div class="row pb-4">
            <div class="col-md-8">
                <div class="card border-0">
                    <div class="card-header">
                        My Cart
                    </div>
                    @foreach (\Cart::getContent() as $item)

                        <div class="row border-bottom">
                            <div class="col-lg-3">
                                <img src="{{ asset('/uploads/products/small/'.$item->attributes->image) }}" class="cart-image" alt="">
                            </div>
                            <div class="col-lg-9 pt-3">
                                <p>{{$item->name}}</p>
                                <form action="{{ route('cart.update', $item->id) }}" method="post">
                                    @csrf
                                    <div class="form-innder">
                                        <a href="javascript:void();" onclick="decrement(this,{{ $item->id }})"
                                            class="cart-minus"><i class="fa-solid fa-minus"></i>
                                        </a>
                                        <input type="text" name="quantity" value="{{ $item->quantity }}" min="1"
                                            class="quantity-input-field" readonly />
                                        <a href="javascript:void();" onclick="increment(this,{{ $item->id }})"
                                            class="cart-plus"><i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                </form>

                                <div class="col-lg-2 pt-3">
                                    <p class="fw-bold">{{currency_sign()}} {{ currency_amount($item->price)  }}</p>
                                </div>
                                @php
                                    $is_tailoring = \App\Models\Product::where('id',$item->id)->where('is_tailoring',1)->first();
                                @endphp
                                {{-- <a href="javascript::void();" id="giftWrap" class="common_a"
                                    onclick="giftID({{ $item->id }})">Gift wrap</a> | --}}
                                    @if(isset($is_tailoring->tailoring_charge))
                                    <a href="javascript::void();" id="trailoring" class="common_a"
                                    onclick="trailoringDiv({{ $item->id }})">Trailoring</a> |
                                    @endif
                                <a href="javascript::void();" class="common_a"
                                    onclick="cartRemove({{ $item->id }})"> Remove</a>
                                
                                {{-- <div class="wrap" id="wrapper_{{ $item->id }}" style="display: none">

                                    <p>Select a Wrapping Paper Below</p>
                                    <ul class="wrapping-ul">
                                        @foreach ($wrapper as $wp)
                                        {{$wp->price}}
                                        <br>
                                        {{$item->id}}
                                            <li style="padding-left:5px;cursor: pointer;"
                                                onclick="wrapping({{ $wp->id}},{{$wp->price}},{{$item->id}})">
                                                <div class="wp_images{{$wp->id}} wp_images" id="UpdateWrap{{$wp->id}}{{$item->id}}">
                                                    <img style="width: 60px; height:60px"
                                                        src="{{ asset($wp->image) }}" alt="">
                                                </div>
                                                <p href="" style="margin-top:5px"> {{currency_sign()}} {{ currency_amount($wp->price) }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <br />
                                    
                                    <form action="{{ route('gift.cart.update', $item->id) }}" method="post" onclick="wrppingForm({{$item->id}})" >
                                        @csrf
                                        <div class="row w-100">
                                            <p class="gift-msg">Gift Message (Optional)</p>
                                            <div class="form-box w-100">
                                                <input type="hidden" name="wp_price"  id="wp_price{{$item->id}}" value="" required>
                                                <div class="from_name_group form-group">
                                                    <label for="">From</label>
                                                    <input name="from_name" type="text" class="from_name form-control"
                                                        placeholder="Enter Name" autocomplete="off">
                                                </div>
                                                <div class="to_name_group form-group">
                                                    <label for="">To Name</label>
                                                    <input name="to_name" type="text" class="to_name form-control"
                                                        placeholder="Enter Name" autocomplete="off">
                                                </div>
                                                <div class="message-group form-group">
                                                    <label for="">Message</label>
                                                    <textarea type="text" class="msg-field form-control" name="message" placeholder="Message"></textarea>
                                                </div>

                                                <button type="submit" disabled class="save-btn btn" id="save{{$item->id}}">Save</button>
                                                <a class="cancel-btn btn" id="cancel-btn{{ $item->id }}"
                                                    onclick="hideGiftbox({{ $item->id }})">Cancel</a>
                                            </div>
                                            

                                        </div>
                                    </form>
                                </div> --}}
                                {{-- <div class="wrap" id="trailoring_{{ $item->id }}" style="display: none">

                                    
                                    
                                    <form action="{{ route('trailoring.add', $item->id) }}" method="post" >
                                        @csrf
                                        <div class="row w-100">
                                            <p class="gift-msg">Trailoring (Optional)   @if(isset($is_tailoring->tailoring_charge)) Trailoring Price  {{currency_sign()}} {{ currency_amount($is_tailoring->tailoring_charge) }} @endif </p>
                                            <div class="form-box w-100">
                                                @if(isset($is_tailoring->tailoring_charge))
                                                <input type="hidden" name="trailoring_price"  value="{{$is_tailoring->tailoring_charge}}" required>
                                                @endif
                                                <div class="message-group form-group">
                                                    <label for="">Description</label>
                                                    <textarea type="text" class="form-control" name="description" placeholder="Description Here"></textarea>
                                                </div>

                                                <button type="submit" class="save-btn btn mx-3" id="save{{$item->id}}">Save</button>
                                                <a class="cancel-btn btn" id="cancel-btn{{ $item->id }}"
                                                    onclick="hideTrailoring({{ $item->id }})">Cancel</a>
                                            </div>
                                            

                                        </div>
                                    </form>
                                </div> --}}
                            </div>
                        </div>
                
                    @endforeach
                </div>


            </div>
            <div class="col-md-4">
                <div class="cart-right-side">
                    <h5 class=" card-header">Order Summery </h5>
                    <div class="single-part d-flex">
                        <span class="fw-bolder my-auto">Subtotal:</span> <span
                            class="ms-auto mx-2">{{currency_sign()}} {{ currency_amount(\Cart::getTotal()) }} </span>
                    </div>
                    @php 
                    // $sum = 0;
                    // $trailoring_sum = 0;
                    // foreach (\Cart::getContent() as $item) {
                    //     $sum +=  $item->wp_price;
                    //     $trailoring_sum +=  $item->tailoring_charge;
                    // }

                    @endphp
                    {{-- <div class="single-part d-flex">
                        <span class="fw-bolder my-auto">Wrapping Charge:</span> <span
                            class="ms-auto mx-2">{{currency_sign()}} {{ currency_amount($sum)}} </span>
                    </div>
                    <div class="single-part d-flex">
                        <span class="fw-bolder my-auto">Trailoring Charge:</span> <span
                            class="ms-auto mx-2">{{currency_sign()}} {{ currency_amount($trailoring_sum)}} </span>
                    </div> --}}
                    {{-- <div class="single-part d-flex">
                    <span class="fw-bolder my-auto">Shipping:</span> <span class="ms-auto mx-2">100 TK</span>
                </div> --}}
                    <div class="single-part d-flex">
                        <span class="fw-bolder my-auto">Total:</span> 
                        {{-- <span class="ms-auto mx-2">{{currency_sign()}} {{ currency_amount(\Cart::getTotal() + $sum + $trailoring_sum) }} </span> --}}
                        <span class="ms-auto mx-2">{{currency_sign()}} {{ currency_amount(\Cart::getTotal()) }} </span>
                    </div>
                    <div class="d-flex">
                        <a href="{{ route('checkout') }}" class="btn check-out-btn">Checkout</a>
                        <a href="{{ route('home.index') }}" class="btn continue-btn ms-auto">Continue Shipping</a>
                    </div>
                </div>
            </div>
        </div>
</section>
@push('website-js')
    <script>
        // increment
        function increment(sib, id) {
            var siblings = $(sib).siblings('.quantity-input-field');
            var data = siblings.val();
            data++;
            $(siblings).val(data);

            let url = '/cart-increment-decrement/' + data + '/' + id;
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function(res) {
                    if (res) {
                        setTimeout(function() {
                            location.reload();
                        }, 1500)

                    }
                }
            })


        }
        // decrement
        function decrement(sib, id) {
            var siblings = $(sib).siblings('.quantity-input-field');
            var data = siblings.val();
            if (data < 2) {
                data = 1;
                $(siblings).val(data);

            } else {
                data--;
                $(siblings).val(data);

            }

            let url = '/cart-increment-decrement/' + data + '/' + id;
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function(res) {
                    if (res) {
                        setTimeout(function() {
                            location.reload();
                        }, 1500)

                    }
                }
            })



        }
    </script>

    <script>
        function giftID(id) {
            
                let cartclass = '#wrapper_' + id;
                $(cartclass).toggle();
            
        }
    </script>

    <script>
        function hideGiftbox(id) {
            let cartclass = '#wrapper_' + id;
            $(cartclass).hide();
        }
    </script>
    <script>
        function cartRemove(id) {
            let url = '/ajax-cart-remove/' + id;
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function(res) {
                    if (res) {
                        location.reload();

                    }
                }
            })
        }
    </script>

    <script>
        function wrapping(id,price,divId){
            let cartclass = '#UpdateWrap' + id+ divId;
            $('.wp_images').removeClass('borderBlack');
            $(cartclass).addClass('borderBlack');
            $('#wp_price' + divId).val(price);
            let button = document.querySelector("#save"+divId);
            if (price == '') {
                button.disabled = true;
            }
            else {
                button.disabled = false;
                }   
        }
            
        
    </script>
    <script>
        function trailoringDiv(id){
            $('#trailoring_'+id).toggle();
        }
        function hideTrailoring(id){
            $('#trailoring_'+id).hide();
        }
    </script>
    
@endpush
@endsection
