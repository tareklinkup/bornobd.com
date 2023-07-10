@extends('layouts.website')
@section('title', 'Checkout')
@push('website-css')
    <link rel="stylesheet" href="{{ asset('website') }}/css/cart.css">
@endpush
@section('website-content')
<style>
    .login-input
    {
        font-size: 14px
    }
</style>
    <section>
        <div class="container mt-3">
            <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item fw-bold"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active fw-bolder" aria-current="page">Checkout</li>
                </ol>
            </nav>
            <form action="{{ route('checkout.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="checkout-form">
                            <h5>Billing Address</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group my-1 ">
                                        @if (Auth::guard('customer')->check())
                                            <input type="text" name="customer_name"
                                                class="form-control login-input shadow-none @error('customer_name') is-invalid @enderror"
                                                value="{{ Auth::guard('customer')->user()->name }}">
                                        @else
                                            <input type="text" name="customer_name" placeholder="Enter Your Name"
                                                class="form-control login-input @error('customer_name') is-invalid @enderror shadow-none" required>
                                        @endif
                                        @error('customer_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group my-1">
                                        @if (Auth::guard('customer')->check())
                                            <input type="text" name="customer_mobile" class="form-control login-input shadow-none"
                                                value="{{ Auth::guard('customer')->user()->phone }}">
                                        @else
                                            <input type="text" name="customer_mobile" placeholder="Enter Your Mobile Number"
                                                class="form-control login-input @error('customer_mobile') is-invalid @enderror shadow-none" required>
                                        @endif
                                        @error('customer_mobile')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group my-1">
                                        @if (Auth::guard('customer')->check())
                                            <input type="email" name="customer_email" value="{{ Auth::guard('customer')->user()->email }}"
                                                placeholder="Enter Email"
                                                class="form-control login-input shadow-none @error('customer_email') is-invalid @enderror"
                                                value="">
                                        @else
                                            <input type="email" name="customer_email" placeholder="Enter Your Email"
                                                class="form-control login-input shadow-none @error('customer_email') is-invalid @enderror shadow-none" required>
                                        @endif
                                    </div>
                                    @error('customer_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group my-1">
                                        <select name="type_id" id="delivery_type" class="form-control login-input @error('area_id') is-invalid @enderror shadow-none" required>
                                            <option value="" disabled selected>Delivery Type</option>
                                            <option value="1">Cash on Delivery</option>
                                            <option value="2">Collect From Shop</option>
                                            <option value="3">Courier</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="aria-part">
                                    <div class="form-group my-1">
                                        <select name="area_id" id="area_id" class="form-control login-input shadow-none">
                                            <option value="" disabled selected>Select Area</option>
                                            @foreach ($delivery_charge as $item)
                                                <option value="{{ $item->id }}">{{ $item->area }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="shop-part" >
                                    <div class="form-group my-1">
                                        <select name="shop_id" id="shop_id" class="form-control login-input shadow-none">
                                            <option value="" disabled selected>Select Shop</option>
                                            @foreach ($store as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6" id="curier-part">
                                    <div class="form-group my-1">
                                        <select name="courier_id" id="courier_id" class="form-control login-input shadow-none">
                                            <option value="" disabled selected>Select Courier</option>
                                            @foreach ($courier as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group my-1">
                                @if (Auth::guard('customer')->check())
                                    <textarea name="billing_address" id="" class="form-control login-input shadow-none @error('billing_address') is-invalid @enderror" rows="2" placeholder="Billing Address"
                                        required>{{ Auth::guard('customer')->user()->address }}</textarea>
                                @else
                                    <textarea name="billing_address" id="" class="form-control login-input shadow-none @error('billing_address') is-invalid @enderror" rows="2" placeholder="Billing Address"
                                        required></textarea>
                                @endif
                                @error('billing_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                            <div class="form-group my-1">
                                <textarea name="note" id="" class="form-control login-input shadow-none" rows="2" placeholder="Order Note"></textarea>
                            </div>
                            <input type="checkbox" id="address" name="address" value="address" checked>
                            <label for="address" class="fw-bolder mt-3">Shipping Addresss Same As Billing
                                Address</label><br>

                            <div class="shipping-part">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group my-1 mx-2">
                                            <input type="text" name="shipping_name" class="form-control login-input shadow-none"
                                                placeholder="Name" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group my-1">
                                            <input type="text" name="shipping_phone" placeholder="Phone"
                                                class="form-control login-input shadow-none" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group my-1">
                                            <input type="email" name="shipping_email" placeholder="Enter Email"
                                                class="form-control login-input shadow-none" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group my-1">
                                            <textarea name="shipping_address" id="" class="form-control login-input shadow-none" rows="1"
                                                placeholder="Shipping Address"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">

                        <div class="order-history-part">
                            <h5 class=" text-center">Order Summery</h3>
                                <table class="order-summery-table">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Size</th>
                                            <th>Color</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>

                                    </thead>
                                    <tbody>
                                        {{-- @php
                                        $sum = 0;
                                        $trailoring_sum = 0;
                                        foreach (\Cart::getContent() as $item) {
                                            $sum +=  $item->wp_price;
                                            $trailoring_sum +=  $item->tailoring_charge;
                                        }
                                        @endphp --}}

                                        @foreach (\Cart::getContent() as $item)
                                            <tr>
                                                <td><img src="{{ asset('uploads/products/small/' . $item->attributes->image) }}"
                                                        alt="" class="check-out-img"></td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->attributes->size }}</td>
                                                <td>{{ $item->attributes->color }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{currency_sign()}}{{ currency_amount($item->quantity * $item->price) }}</td>
                                            </tr>
                                        @endforeach
                                        @if (Auth::guard('customer')->check())
                                            @if(!session()->has('is_coupon_apply'))
                                            <tr>
                                                <td> <label for="applyCupon">Apply Cuppon</label></td>
                                                <td> <input type="checkbox" id="applyCupon" onchange="cuponClick(this)">
                                                </td>
                                                <td></td>
                                                <td>
                                                    <form id="CupponApply">
                                                        <input type="text" id="myCupon" name="cupon_code" disabled
                                                            placeholder="Enter Your Cupon"> <button
                                                            style="display: none; margin:0 auto"
                                                            class="btn btn-primary btn-sm mt-1" id="cupon-btn">Apply</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endif
                                        @endif
                                        <tr>
                                            <td colspan="3" class="mx-2"><b>Subtotal</b></td>
                                            <td>{{currency_sign()}}{{ currency_amount(\Cart::getSubTotal()) }}</td>
                                        </tr>
                                        {{-- <tr>
                                            <td colspan="3" class="mx-2"><b>Trailoring Charge</b></td>
                                            <td>{{currency_sign()}}{{ currency_amount($trailoring_sum) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="mx-2"><b>Wrapping Charge</b></td>
                                            <td>{{currency_sign()}}{{ currency_amount($sum) }}</td>
                                        </tr> --}}

                                        @php
                                            $member_discount = 0;
                                        @endphp

                                        @if (Auth::guard('customer')->check() && !is_null(Auth::guard('customer')->user()->membership_discount) && !session()->has('is_coupon_apply'))
                                        @php
                                            $member_discount = Auth::guard('customer')->user()->membership_discount;
                                        @endphp
                                        <tr>
                                            <td colspan="3" class="mx-2"><b>Membership Discount ({{$member_discount}}%)</b></td>
                                            <td>{{currency_sign()}}<span id="member_ship_amount">0</span></td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td colspan="3" class="mx-2"><b>Delivery Charge</b></td>
                                            <td><span id="charge">0</span></td>
                                            <input type="hidden" id="freeShipping" value="{{ $content->free_shipping }}">
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="mx-2"><b>Total</b></td>
                                            <td>{{currency_sign()}}<span id="total">{{ \Cart::getTotal() }}</span></td>
                                            {{-- <td>{{currency_sign()}}<span id="total">{{ \Cart::getTotal() + $sum + $trailoring_sum }}</span></td> --}}
                                        </tr>

                                    </tbody>
                                </table>

                                <div class="d-flex mt-2">
                                    <button type="submit" class="btn check-out-btn custom-btn">Checkout</button>
                                    <a href="#" class="btn continue-btn ms-auto custom-btn">Continue Shipping</a>
                                </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <section class="py-4"  >
        <div class="container">
            <div class="custom-border-bottom">
                <h3 class="text-center title-text">Similar Product</h3>
            </div>

            <div class="container mt-3">
                @if(count($product) > 4)
                <div class="owl-carousel product-carousel owl-theme">
                    @foreach ($product as $item)
                        <div class="item product-single">
                            <div class="product-img">
                                <a href="{{ route('product.details', $item->slug) }}">
                                    <img src="{{ asset('uploads/products/thumbnail/' . $item->thumb_image) }}" alt=""
                                        class="w-100 front-img">
                                    @isset($item->productImage[0])
                                        <img src="{{ asset('/uploads/products/others/thumbnail/' . $item->productImage[0]->other_mediam_image) ?? asset('noimage.png') }}"
                                            alt="" class="w-100 back-img">
                                    @endisset

                                </a>
                                <i class="fa-solid fa-plus modal-plus-icon"
                                    onclick="productModal({{ $item->id }})"></i>
                            </div>
                            <div class="product-content">
                                <a href="{{ route('product.details', $item->slug) }}">
                                    <h5 class="m-0 product-name">{{ $item->name }}</h5>
                                </a>
                                <p style="font-size:14px"> {{currency_sign()}}{{ $item->currency_amount }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                @else
                <div class="row">
                    @foreach ($product as $item)
                        <div class="col-md-3 col-6">
                            <div class="product-single">
                                <div class="product-img">
                                    <a href="{{ route('product.details', $item->slug) }}">
                                        <img src="{{ asset('uploads/products/thumbnail/' . $item->thumb_image) }}"
                                            alt="" class="w-100 front-img">
                                        @isset($item->productImage[0])
                                            <img src="{{ asset('/uploads/products/others/thumbnail/' . $item->productImage[0]->other_mediam_image) ??asset('noimage.png') }}"
                                                alt="" class="w-100 back-img">
                                        @endisset

                                    </a>
                                    <i class="fa-solid fa-plus modal-plus-icon"
                                        onclick="productModal({{ $item->id }})"></i>
                                </div>
                                <div class="product-content">
                                    <a href="{{ route('product.details', $item->slug) }}">
                                        <h5 class="m-0 product-name">{{ $item->name }}</h5>
                                    </a>
                                    <p> {{currency_sign()}}{{$item->currency_amount}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

            </div>
            {{-- {{ $product->links() }} --}}
        </div>

    </section>

    @push('website-js')
        <script>
            member_discount_calculate();
            $(document).on("change", "#area_id", function() {
                var area_id = $("#area_id").val();
                console.log(area_id)
                var freeShipping = $("#freeShipping").val();
                // alert(freeShipping);
                $.ajax({
                    url: "{{ route('get.charge') }}",
                    type: "GET",
                    data: {
                        area_id: area_id
                    },
                    success: function(data) {
                        var total = '<?php echo \Cart::getTotal(); ?>';
                        let rate = '{{currency_rate()}}';


                        if ((parseFloat(total) >= parseFloat(freeShipping)) || '{{$is_free_shipping}}') {
                            $('#charge').text('Free Shipping 0');
                            $('#total').text(total);
                        } else {
                            let charge = data;
                            charge = parseFloat(rate * charge).toFixed(2);
                            $('#charge').text('{{currency_sign()}}'+charge);
                            var total_amount = parseFloat(total) + parseFloat(data);
                            $('#total').text(total_amount);
                        }

                        member_discount_calculate();
                    }
                });
            });

            function member_discount_calculate(){
                let total = parseFloat($('#total').text());
                let discount_percent = parseFloat('{{$member_discount}}');

                let discount = ((total * discount_percent) / 100).toFixed(2);

                let total_amount = (total - discount).toFixed(2);

                let rate = '{{currency_rate()}}';
                total_amount = parseFloat(rate * total_amount).toFixed(2);
                discount = parseFloat(rate * discount).toFixed(2);

                $('#member_ship_amount').text(discount);
                $('#total').text(total_amount);

            }
        </script>

        <script>
            $(document).ready(function() {
                var value = $('#address').val();
                $('#address').click(function() {
                    $(".shipping-part").toggle(this.unchecked);
                });
            })
        </script>


        <script>
            function cuponClick(checkboxElem) {
                var cuponbox = document.getElementById("applyCupon");
                var cupon = document.getElementById("myCupon");
                var cupon_btn = document.getElementById("cupon-btn");
                var memberMobile = document.getElementById("memberMobile");
                var member_btn = document.getElementById("member-btn");
                if (checkboxElem.checked) {
                    cupon.disabled = false;
                    cupon_btn.style.display = "block";
                    ProMember.checked = false;
                    memberMobile.disabled = true;
                    member_btn.style.display = "none";
                } else {
                    cupon.disabled = true;
                    cupon_btn.style.display = "none";

                }
            }
        </script>
        <script>
            function memberApply(checkboxElem) {
                var ProMember = document.getElementById("ProMember");
                var memberMobile = document.getElementById("memberMobile");
                var member_btn = document.getElementById("member-btn");

                var cuponbox = document.getElementById("applyCupon");
                var cupon = document.getElementById("myCupon");
                var cupon_btn = document.getElementById("cupon-btn");
                if (checkboxElem.checked) {

                    memberMobile.disabled = false;
                    member_btn.style.display = "block";

                    cuponbox.checked = false;
                    cupon.disabled = true;
                    cupon_btn.style.display = "none";

                } else {
                    memberMobile.disabled = true;
                    member_btn.style.display = "none";
                }
            }
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '#cupon-btn', function(e) {
                e.preventDefault();
                var cupon_code = $('#myCupon').val();

                $.ajax({
                    url: '{{ route('cupon.check') }}',
                    type: 'GET',
                    data: {
                        cupon_code: cupon_code,
                    },
                    success: function(res) {

                        console.log(res)
                        if (res == 'opps') {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            }
                            toastr.error('invalid Code');
                        } else {
                            location.reload();
                        }
                        // alert(res);
                    }
                })
            })
        </script>

        <script>
            $('#delivery_type').on('change',function(){
                let value = $(this).val();
                if(value == 1){
                    $('#aria-part').show();
                    $('#shop-part').hide();
                    $('#curier-part').hide();
                    $('#area_id').attr('required', 'required');
                    $('#shop_id').removeAttr('required');
                    $('#courier_id').removeAttr('required');
                    $('#area_id').val('');
                    $('#courier_id').val('');
                }
                if(value == 2){
                    $('#aria-part').hide();
                    $('#shop-part').show();
                    $('#curier-part').hide();
                    $('#shop_id').attr('required', 'required');
                    $('#area_id').removeAttr('required');
                    $('#courier_id').removeAttr('required');
                    $('#shop_id').val('');
                    $('#courier_id').val('');
                }
                if(value == 3){
                    $('#aria-part').hide();
                    $('#shop-part').hide();
                    $('#curier-part').show();
                    $('#courier_id').attr('required', 'required');
                    $('#shop_id').val('');
                    $('#area_id').val('');
                    $('#shop_id').removeAttr('required');
                    $('#area_id').removeAttr('required');
                }

            })
        </script>
    @endpush
@endsection
