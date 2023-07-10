@extends('layouts.website')
@section('title', 'Product Details')
@section('website-content')
    @push('website-css')
    @endpush
    <div class="container">
        <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">{{ $product->name }} details</li>
            </ol>
        </nav>
    </div>
    <section class="product-details mt-3">
        <div class="container">
            <div class="row">
                <div class="col-md-5 text-center">
                    <div class="owl-carousel modal-carousel">
                        <div class="zoom-img-outer parent_of_img text-center">
                            <img src="{{ asset('/uploads/products/original/' . $product->main_image) }}"
                                class="w-100 zoomImg product_img"  >
                        </div>
                        @foreach ($product->productImage as $item)
                            <div class="zoom-img-outer parent_of_img text-center">
                                <img src="{{ asset('/uploads/products/others/original/' . $item->other_main_image) }}"
                                    class="w-100 zoomImg product_img">
                            </div>
                        @endforeach
                    </div>
                    <div class="owl-carousel product-details-slider">
                        <img src="{{ asset('/uploads/products/original/' . $product->main_image) }}" alt=""
                            onclick="imageChange({{ $product->id }})" >

                        @foreach ($product->productImage as $item)
                            <img src="{{ asset('/uploads/products/others/small/' . $item->other_small_image) }}" alt=""
                                onclick="imageChange({{ $item->id }})">
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <h3 class="mt-3 detail-product">{{ $product->name }}</h3>

                    <input type="hidden" id="product_code" value="{{ $product->product_code }}">
                    @if ($product->discount != '')
                        <div class="d-flex">
                            <p class="mb-1 detail-text"> <span class="">Price:</span>
                                <span class=" pe-3 text-danger">
                                    {{currency_sign()}}{{currency_amount(calculateDiscount($product->price, $product->discount)) }}
                                </span>
                                <span><del class="text-danger">{{currency_sign()}}{{ $product->currency_amount }}</del></span>
                            </p>
                        </div>
                    @else
                        <p class="mb-1 detail-text"><span class="">Price:</span> {{currency_sign()}}{{ $product->currency_amount }}</p>
                    @endif
                    <form action="" id="WishList">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_id" id="product_id" value="">
                        <button class="wishlist-btn detail-text" type="submit"><i class="fa-regular fa-heart"></i> Add To
                            Wishlist</button>
                    </form>

                    <form action="{{ route('cart.add', $product->id) }}" method="post">
                        @csrf

                        <div class="detail-text">
                            <span class="">Category:</span> <a
                            href="{{ route('categroy.product', $product->category->slug) }}">{{ $product->category->name }}</a>
                        </div>
                        @php
                            $color = explode(',', $product->color_id);
                        @endphp
                        <div class="detail-text">
                            <span class="">Color:</span>
                            @foreach ($colors as $item)
                                @foreach ($color as $key => $s)
                                    @if ($s == $item->id)
                                        <input type="radio" name="color_id" value="{{ $item->id }}" label=""
                                            class="size-field" {{ $key == 0 ? 'checked' : '' }}
                                            style="background:{{ $item->code }};" onclick="color(this)">
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                        <div class="select-size">
                            <label for="" class="detail-text">Size: </label>
                            @php
                                $size = explode(',', $product->size_id);
                            @endphp

                            @foreach ($sizes as $item)
                                @foreach ($size as $key => $s)
                                    @if ($s == $item->id)
                                        <input type="radio" name="size_id" value="{{ $item->id }}"
                                            label="{{ $item->name }}" onclick="size(this)" class="size-field size"
                                            {{ $key == 0 ? 'checked' : '' }}>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                        <p>
                            {!! $product->short_details !!}
                        </p>
                        <div class="d-flex">
                            <div class="detail-text">
                                <label class="" for="">Quantity: </label>
                                <select name="quantity" id="" class="mx-2 quantity-field quantity">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                            </div>
                            <div>
                                <div style="cursor: pointer" id="bulkQuntity" onclick="bluckQuntity({{ $product->id }})"
                                    class="wishlist-btn">For Bulk Quantity</div>
                            </div>
                            <div style="cursor: pointer" id="bulkQuntity"   class=""></div>
                        </div>

                        <p class="mb-1 detail-text"><span class="">Stock:</span> <span
                                id="Stockavailable">Available</span></p>


                        <div class="d-flex">
                            <button type="submit" class="btn add-to-cart-modal">Add To Cart</button>
                    </form>
                    <form action="{{ route('checkout.cart', $product->id) }}" method="post">
                        @csrf
                        <input type="hidden" name="quantity" id="quantity" value="1">
                        <input type="hidden" name="size_id" id="size" value="">
                        <input type="hidden" name="color_id" id="color" value="">
                        <button type="submit" class="btn checkout-btn">Checkout</a>
                    </form>

                </div>

                <div>
                    <ul class="mt-3 cart-content-list">
                        <li>Free Delivary at {{currency_sign()}}{{ currency_amount($content->free_shipping) }} purchase</li>
                        <li>Product color may slghtly, depanding on light source or your device's screen resolution</li>
                        <li><div style="color:rgb(7, 39, 184); cursor:pointer"  id="storeID">CHCEK IN-STORE AVAILABiLITY</div> </li>
                    </ul>
                    {{-- size guide --}}
                </div>
            </div>

            <div class="col-md-3">
                @foreach ($service as $item)
                    <div class="p-card row vertical-align">
                        <div class="col-md-3 no-padding">
                            <img style="width: 50px" src="{{ asset($item->image) }}">
                        </div>
                        <div class="col-md-9">
                            <h5>{{ $item->title }}</h5>
                            <p>{!! Str::limit($item->details, 50) !!}</p>
                        </div>
                    </div>
                @endforeach
               <div style="cursor: pointer" id="sizeGuides" onclick="sizeGuide({{ $product->id }})"><img class="w-100" src="{{ asset($product->sizeguide) }}" alt=""></div>

            </div>
        </div>
        <div class="product-details mt-3" id="tabpane">
            <div class="product-heading-title">
                <h5>Product Details</h5>
            </div>
            {{-- {!! $product->description !!} --}}
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details" data-bs-toggle="tab" data-bs-target="#contact"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">Product Details</button>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link " id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">Branch</button>
                </li> --}}
                {{-- <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Size Guide</button>
                </li> --}}

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#review"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">Product Review</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade w-50 " id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Branch Name</th>

                                {{-- <th scope="col">Stock</th> --}}

                            </tr>
                        </thead>
                        <tbody id="branchWiseStock">

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <img class="w-100" src="{{ asset($product->sizeguide) }}" alt="">
                </div>
                <div class="tab-pane fade show  active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    {!! $product->description !!}
                </div>
                <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row mt-3">
                        <div class="col-6">
                            <h5 class="text-center login-title">Review List</h5>
                            <div id="reviewList">

                            </div>
                        </div>
                        <div class="col-6">
                            <form id="reviewForm" action="" method="post">
                                @csrf
                                <h5 class="text-center login-title">Review Product</h5>
                                <div class="form-group my-1">
                                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                                    @if (Auth::guard('customer')->check())
                                        <input type="text" id="customer_name" name="customer_name"
                                            value="{{ Auth::guard('customer')->user()->name }}" placeholder="Enter Name"
                                            class="form-control mt-3 login-input @error('customer_name') is-invalid @enderror"
                                            autocomplete="off">
                                    @else
                                        <input type="text" id="customer_name" name="customer_name"
                                            value="{{ old('customer_name') }}" placeholder="Enter Name"
                                            class="form-control mt-3 login-input @error('customer_name') is-invalid @enderror"
                                            autocomplete="off">
                                    @endif

                                    <span id="nameError" class="text-danger text-italic"></span>
                                    @error('customer_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group my-1">
                                    @if (Auth::guard('customer')->check())
                                        <input type="text" id="customer_email" name="customer_email"
                                            value="{{ Auth::guard('customer')->user()->email }}"
                                            placeholder="Enter Email"
                                            class="form-control login-input mt-3  @error('customer_email') is-invalid @enderror"
                                            autocomplete="off">
                                    @else
                                        <input type="text" id="customer_email" name="customer_email"
                                            value="{{ old('customer_email') }}" placeholder="Enter Email"
                                            class="form-control login-input mt-3  @error('customer_email') is-invalid @enderror"
                                            autocomplete="off">
                                    @endif

                                    <span id="emailError" class="text-danger text-italic"></span>
                                    @error('customer_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group my-1">
                                    <textarea rows="4" cols="50" name="review" class="form-control" placeholder="Enter Your review here..."
                                        id="reviewDes"></textarea>
                                    <span id="reviwError" class="text-danger text-italic"></span>
                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn add-to-cart-modal">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section>
        <div class="container mt-5">
            <h3 class="">Similar Product</h3>
            <div class="mt-3">
                <div class="scrolling-pagination">
                    <div class="row ">
                        @foreach ($similerProduct as $item)
                            <div class="col-md-3 col-6">
                                <div class="product-single">
                                    <div class="product-img">
                                        <a href="{{ route('product.details', $item->slug) }}">
                                            <img src="{{ asset('/uploads/products/thumbnail/' . $item->thumb_image) }}"
                                                alt="" class="w-100 front-img">
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
                                        <p>{{currency_sign()}}{{ $item->currency_amount }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $similerProduct->links() }}
                    </div>
                </div>
            </div>
        </div>

        {{-- bluck quation modal --}}
        <div id="bluckQutation" class="modal">
            <div class="modal-dialog popUpModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bluk Quantity</h5>
                        <button type="button" class="closeBulk" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class=" p-4">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Name</label>
                                <input type="text" id="customerName" class="form-control" aria-describedby="emailHelp">
                                <span id="customerNameError" class="text-danger text-italic"></span>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                                <input type="text" id="customerMobile" class="form-control" aria-describedby="emailHelp">
                                <span id="customerMobileError" class="text-danger text-italic"></span>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email</label>
                                <input type="text" id="customerEmail" class="form-control" aria-describedby="emailHelp">
                                <span id="customerEmailError" class="text-danger text-italic"></span>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Details</label>
                                <textarea name="" class="form-control" id="customerMessage" cols="30" rows="2"></textarea>
                                <span id="customerMessageError" class="text-danger text-italic"></span>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
{{-- size guide modal --}}
        <div id="sizeGuide" class="modal">
            <div class="modal-dialog popUpModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Size Guide</h5>
                        <button type="button" class="closeGuide" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <img src="{{ asset($product->name) }}" alt=""> --}}
                        <img class="w-100" src="{{ asset($product->sizeguide) }}" alt="">
                    </div>

                </div>
            </div>
        </div>
{{-- size availability modal --}}
        <div id="sizeAvailability" class="modal">
            <div class="modal-dialog popUpModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Check Store Availability</h5>
                        <button type="button" class="closeStore" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        {{-- <img src="{{ asset($product->name) }}" alt=""> --}}
                        <div class="col-6">
                            <p>Please Select Size</p>
                        @foreach ($sizes as $item)
                            @foreach ($size as $key => $s)
                                @if ($s == $item->id)
                                <div class="vertical-align">
                                    <input style="height: 20px;width:20px; " type="radio" name="size_id" value="{{ $item->id }}"
                                         onclick="size(this)" class=""
                                        {{ $key == 1 ? 'checked' : '' }}> <span style="font-size:20px;padding-left:7px">{{ $item->name }}</span> <br></div>
                                @endif
                            @endforeach
                        @endforeach

                        </div>
                        <div class="col-6">
                            <img class="w-100" src="{{ asset('/uploads/products/thumbnail/' . $product->thumb_image) }}" alt="">
                        </div>
                        <button class="btn btn-secondary rounded-0 mt-2 bg-dark">Check</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!---- product modal end--->
    @push('website-js')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
            });
        </script>

        <script>


            $(document).on('submit', '#reviewForm', function(e) {
                e.preventDefault();
                var product_id = $('#product_id').val();
                // var rate = $('<style>.rating-counter:before{content:""}</style>');

                var customer_name = $('#customer_name').val();
                var customer_email = $('#customer_email').val();
                var review = $('#reviewDes').val();
                var rate = 0;
                $('.rating-counter').each(function() {
                    var content = window.getComputedStyle(this, ':before').content;
                    var rate = content;
                });

                $.ajax({
                    url: '{{ route('review.store') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        product_id: product_id,
                        rate: rate,
                        customer_name: customer_name,
                        customer_email: customer_email,
                        review: review,
                    },
                    success: function(success) {
                        if (success == 'Opps') {
                            alert('Please Login First')
                            location.replace('/customer-login')
                        } else {
                            alert(success);
                            console.log(success)
                            allReview();
                            $('#customer_name').val('');
                            $('#customer_email').val('');
                            $('#reviewDes').val('');

                            $('#nameError').text('');
                            $('#emailError').text('');
                            $('#reviwError').text('');
                        }

                        // location.reload();

                    },
                    error: function(error) {
                        $('#nameError').text(error.responseJSON.errors.customer_name);
                        $('#emailError').text(error.responseJSON.errors.customer_email);
                        $('#reviwError').text(error.responseJSON.errors.review);
                    }
                })
            })
        </script>

        <script>
            function allReview() {
                var productID = $('#product_id').val();
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ url('rewiew-list') }}/' + productID,
                    success: function(data) {
                        console.log(data);
                        review = ''

                        $.each(data, function(key, value) {
                            review = review + '<div class="card mb-3">'
                            review = review + '<div class="card-body">'
                            review = review + '<blockquote class="blockquote mb-0">'
                            if (value.status == 'p') {

                                review = review + '<p class="pending-comment"> pending </p>'
                            }
                            review = review + '<p>' + value.review + '</p>'
                            review = review + '<footer class="blockquote-footer">' + value.customer_name +
                                '</footer>'
                            review = review + '</blockquote>'
                            review = review + '</div>'
                            review = review + '</div>'
                        })
                        $('#reviewList').html(review);
                    },
                    error: function(error) {
                        jsonValue = jQuery.parseJSON(error.responseText);
                        alert("error" + error.responseText);
                    }
                });
            }
            allReview();
        </script>
        <script>
            function MotherApiBranch() {
                var productID = $('#product_code').val();
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    data: {
                        style: productID
                    },
                    url: '{{ url('mother-api-branch') }}',
                    success: function(res) {
                        // console.log(productID)
                        // let res = data.filter(p=> p['Product code'] == productID);

                        console.log(res);
                        branchWise = '',
                            totalStock = 0,
                            $.each(res, function(key, value) {
                                var key = key + 1;
                                totalStock = totalStock += value.balance;

                                branchWise = branchWise + '<tr>'
                                branchWise = branchWise + '<td>' + key + '</td>'
                                branchWise = branchWise + '<td>' + value.StationName + '</td>'
                                // branchWise = branchWise +'<td>' +value.balance+'</td>'
                                branchWise = branchWise + '</tr>'
                            })
                        $('#branchWiseStock').html(branchWise);
                        console.log(totalStock);
                        if (totalStock > 0) {
                            $('#Stockavailable').text('Available');
                        } else {
                            $('#Stockavailable').text('Out Of Stock');
                        }

                    },
                    error: function(error) {
                        jsonValue = jQuery.parseJSON(error.responseText);
                        alert("error" + error.responseText);
                    }
                });
            }
            MotherApiBranch();
        </script>
        <script>
            // product-details-slider
            $('.product-details-slider').owlCarousel({
                items: 4,
                loop: true,
                dots: true,
                nav: true,
                margin: 2,

            });
        </script>
        <script>
            function imageChange(id) {
                $('.active .parent_of_img').css('width', $('.parent_of_img img').width());
                $('.active .parent_of_img img')
                    .parent()
                    .zoom({
                        magnify: 2,
                        target: $('.contain').get(0)
                    });
                var url = '/other-product-img/' + id;
                $.ajax({
                    url: url,
                    type: "get",
                    success: function(res) {
                        console.log(res);
                        $('.active .parent_of_img img').attr('src', res);
                    }
                });
            }
        </script>
        <script>
            // color and size javascript
            function color(div) {
                var value = $(div).val();
                $('#color').val(value);
            }
            $('.color').val();
            $('#color').val($('.color').val());
            $('.size').val();
            $('#size').val($('.size').val());
            $(document).on('click', '.size', function() {
                var val = $(this).val();
                $('#size').val(val);
            })

            $(document).on('change', '.quantity', function() {
                var val = $(this).val();
                $('#quantity').val(val);
            })
        </script>
        <script>
            $(document).on('click', '#WishList', function(e) {
                // alert('ok');
                event.preventDefault();
                var product_id = $('#product_id').val();
                $.ajax({
                    url: "{{ route('wishlist.store') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        product_id: product_id,
                    },
                    success: function(res) {

                        toastr.success(res.title);
                    },
                    error: function(error) {
                        alert('opps faild to added wishlist please login first')
                        location.replace('/customer-login')
                    }
                })
            })
        </script>
        <script></script>



        <script>
            $(document).on('click', '#bulkQuntity', function() {
                $("#bluckQutation").show();
                $("#bluckQutation").css("background-color", "rgb(0 0 0 / 42%)");
            });
            $('.closeBulk').on('click', function() {
                $("#bluckQutation").hide();
            });

            $("#storeID").on('click', function() {
                $('#sizeAvailability').show();
                $("#sizeAvailability").css("background-color", "rgb(0 0 0 / 42%)");
            });
            $('.closeStore').on('click', function(){
                $('#sizeAvailability').hide();
            });
        </script>


        <script>
            function bluckQuntity(id) {
                var productId = id;
                $('#bluckQutation').on('submit', function(e) {
                    e.preventDefault();
                    var product_id = id;
                    var customer_name = $('#customerName').val();
                    var customer_mobile = $('#customerMobile').val();
                    var customer_email = $('#customerEmail').val();
                    var customer_message = $('#customerMessage').val();


                    $.ajax({
                        url: "{{ route('bulk-quation.store') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            product_id: product_id,
                            customer_name: customer_name,
                            customer_mobile: customer_mobile,
                            customer_email: customer_email,
                            customer_message: customer_message,
                        },
                        success: function(res) {
                            console.log(res);
                            toastr.success(res);
                            $("#bluckQutation").hide();
                            $('#customerName').val('');
                            $('#customerMobile').val('');
                            $('#customerEmail').val('');
                            $('#customerMessage').val('');

                            $('#customerNameError').text('');
                            $('#customerEmailError').text('');
                            $('#customerMObiError').text('');
                        },
                        error: function(error) {
                            console.log(error);
                            alert('opps faild to qutaiton');
                            $('#customerNameError').text(error.responseJSON.errors.customer_name);
                            $('#customerEmailError').text(error.responseJSON.errors.customer_email);
                            $('#customerMobileError').text(error.responseJSON.errors.customer_mobile);
                        }
                    })
                })
            }
        </script>

    <script>
        $(document).on('click', '#sizeGuides', function() {
            $("#sizeGuide").show();
            $("#sizeGuide").css("background-color", "rgb(0 0 0 / 42%)");
        });
        $('.closeGuide').on('click', function() {
            $("#sizeGuide").hide();
        });
    </script>
    @endpush
@endsection
