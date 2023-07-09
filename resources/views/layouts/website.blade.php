<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $content->company_name }} | @yield('title')</title>
    <link rel="shortcut icon" href="{{ asset($content->logo) }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('website') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('website') }}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('website') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('website') }}/css/style.css">
    <link href="{{ asset('website/css/toastr.min.css') }}" rel="stylesheet" id="galio-skin">
    <link rel="stylesheet" href="{{ asset('website') }}/css/product.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/smoothness/jquery-ui.css">
     @stack('website-css')
</head>

<body>

    @include('partials.home_page_header')

    @yield('website-content')
    @include('partials.website_footer')
    <style>
        #myModalPopUp {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popUpModal .close {
            position: absolute;
            top: 30px;
            right: 7px;
            background: #f00;
            opacity: 1;
            border-radius: 50%;
            padding: 0px 0px;
            color: #fff;
            font-size: 23px;
            font-weight: 700;
            line-height: 29.5px;
            width: 25px;
            height: 25px;
        }

        #draggable {
            width: 60px;
            height: 60px;
            position: fixed;
            /* background-image: radial-gradient(circle, #ffffff, #cacaca, #979797, #676767, #3b3b3b, #362e37, #361f2b, #360f18, #5a0d1e, #80061f, #a4001a, #c70909); */
            top: 50%;
            z-index: 999;
            /* border-radius: 50%; */
            cursor: pointer;
        }

        #free_shipping{
            display: none;
            position: fixed;
            top: 20%;
            /* background: #f1ce65; */
            cursor: pointer;
            z-index: 999;
            text-align: center;
            
        }

        ul#ui-id-1 {
            z-index: 999;
        }

        #free_shipping h6{
            display: inline;
            color: #fff;
            background: #303030;
            padding: 0 20px;
            border-radius: 15px;
        }
        
        #free_shipping h5{
            color: #603913;
            border-radius: 6px;
            background: #ffff00c7;
            animation: blinkText 1s infinite;
            margin-bottom: 0;
            padding: 5px;
        }
        @keyframes blinkText {
                0%{opacity:0.1;}
            50%{opacity:1; text-shadow: 1px 0px 30px rgb(66, 25, 25);}
            100%{
                opacity:0.1;
            }
        }

    </style>
    <div id="myModalPopUp" class="modal">
        <div class="modal-dialog popUpModal">
            <div class="modal-content">
                <form method="post">
                    <div class="">
                        <button type="button" id="popUpColse" style="top:5px" class="close" data-dismiss="modal"
                            aria-hidden="true">
                            <span style="display:block;margin-top:-4px;">&times;</span>
                        </button>
                    </div>
                    <div class="popUpImage">
                        <a href="#"><img style="width:100%"
                                src="{{ asset($content->pop_up_image) }}" alt=""></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!---- product modal start--->
    <div class="custom-modal">
        <div class="modal-inner container">
            <div class="modal-close-icon">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="row modal-row px-2 py-3 justify-content-center">

                <div class="col-md-6 text-center">
                    <div class="zoom-img-outer parent_of_img text-center">
                        <img src="{{ asset('website') }}/img/product2.jpg" class=" zoomImg modal-img w-100">
                    </div>
                </div>
                <div class="col-md-6">
                    <h3 class="mt-3 detail-product" id="product_name"></h3>
                    <p class="mb-1 detail-text"> <span class="fw-bolder">Price: </span>{{currency_sign()}}<span
                            class="" id="price"></span><span
                            class="pre-price text-danger fw-bolder text-decoration-line-through mx-1"></span></p>

                    <form action="" id="WishList">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id" value="">
                        <button class="wishlist-btn detail-text" type="submit"><i class="fa-regular fa-heart"></i> Add To
                            Wishlist</button>
                    </form>

                    <form action="" method="post" id="modal-form">
                        @csrf
                        {{-- <p> <span class="fw-bolder">Category:</span> <span id="category"
                                class="color-success"></span>
                        </p> --}}
                        <div class="detail-text"> 
                            <span class="">Color:</span>
                            <span id="color-part"></span>
                        </div>

                        <div class="select-size">
                            <label for="" class="detail-text">Size: </label>
                            <span id="size-part"></span>
                        </div>
                        {{-- <p class="text-success mt-2 fw-bolder">In Stock</p> --}}

                        {{-- <p class="text-danger mb-0 mt-2 fw-bolder"> Stock Out</p> --}}

                        <div class="detail-text">
                            <label for="">Quantity</label>
                            <select name="quantity" id="quantity" class="mx-2 quantity-field">
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
                        <div class="d-flex">
                            <button class="btn add-to-cart-modal">Add To Cart</button>

                    </form>
                    <form action="" method="post" id="checkout-form">
                        @csrf
                        <input type="hidden" name="quantity" id="quantity" value="1">
                        <input type="hidden" name="size_id" id="size" value="">
                        <input type="hidden" name="color_id" id="color" value="">
                        <button type="submit" class="btn checkout-btn">Checkout</a>
                    </form>
                </div>
                <div>
                    <ul class="mt-3 cart-content-list">
                        <li>Free Delivary at {{currency_sign()}}{{currency_amount($content->free_shipping)}} purchase</li>
                        <li>Product color may slghtly, depanding on light source or your device's screen resolution</li>
                        <li><a href="">CHCEK IN-STORE AVAILABiLITY</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>



    <script src="{{ asset('website') }}/js/jquery.min.js"></script>
    <script src="{{ asset('website') }}/js/jquery.zoom.js"></script>
    <script src="{{ asset('website/js/toastr.min.js') }}"></script>
    <script src="{{ asset('website') }}/js/owl.carousel.min.js"></script>
    <script src="{{ asset('website') }}/js/bootstrap.bundle.js"></script>
    <script src="{{ asset('website') }}/js/all.min.js"></script>
    <script src="{{ asset('website/js/bootstrap3-typeahead.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    @stack('website-js')
    <script></script>
    <script>
        $(function() {
            $("#draggable").draggable();
        });
        
        $(function() {
            $("#free_shipping").draggable();
        });
    </script>
    <script>
        $(document).ready(function() {
            var baseUri = "{{ url('/') }}";
            var popUpStatus = '<?php echo $content->pop_up_status; ?>'
            if (baseUri == '<?php echo url()->current(); ?>') {
                if (popUpStatus == '1') {
                    $("#draggable").fadeOut();
                    $("#myModalPopUp").css("background-color", "rgb(0 0 0 / 42%)");
                    $("#myModalPopUp").show().delay(5000).fadeOut();
                    $("#draggable").show().delay(5000).fadeIn();
                  
                }

            }
            if (popUpStatus == '1') {
                $('#popUpColse').on('click', function() {
                    $('#myModalPopUp').hide();
                    $("#draggable").show().delay(3000).fadeIn();
                })

                $('.popUpOpen').on('click', function() {
                    $("#draggable").fadeOut();
                    $('#myModalPopUp').show();
                    $("#myModalPopUp").css("background-color", "rgb(0 0 0 / 42%)");
                    $("#myModalPopUp").show().delay(5000).fadeOut();
                    $("#draggable").show().delay(5000).fadeIn();
                })
            }

            let free_shipping_date = '{{$content->happy_hour_date}}';
            
            if(free_shipping_date){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; 
                var yyyy = today.getFullYear();
                if(dd<10) 
                {
                    dd='0'+dd;
                } 
                if(mm<10) 
                {
                    mm='0'+mm;
                } 
                today = yyyy+'-'+mm+'-'+dd;
                if(free_shipping_date == today){
                    let time_from = '{{$content->happy_hour_time_from}}';
                    let time_to = '{{$content->happy_hour_time_to}}';

                    var today = new Date();
                    var time_now = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    if([-1, 0].includes(dateCompare(time_from,time_now)) && [1, 0].includes(dateCompare(time_to,time_now))){
                        $('#free_shipping').show();

                        var countDownDate = new Date(free_shipping_date + " " + time_to).getTime();

                        // Update the count down every 1 second
                        var x = setInterval(function() {

                            // Get today's date and time
                            var now = new Date().getTime();
                                
                            // Find the distance between now and the count down date
                            var distance = countDownDate - now;
                                
                            // Time calculations for days, hours, minutes and seconds
                            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                
                            // Output the result in an element with id="demo"
                            document.getElementById("free_shipping_timer").innerHTML = days + "d " + hours + "h "
                            + minutes + "m " + seconds + "s ";
                                
                            // If the count down is over, write some text 
                            if (distance < 0) {
                                clearInterval(x);
                                $('#free_shipping').hide();
                            }
                        }, 1000);
                    }
                }
            }
        })

        function dateCompare(time1,time2) {
            var t1 = new Date();
            var parts = time1.split(":");
            t1.setHours(parts[0],parts[1],parts[2],0);
            var t2 = new Date();
            parts = time2.split(":");
            t2.setHours(parts[0],parts[1],parts[2],0);

            // returns 1 if greater, -1 if less and 0 if the same
            if (t1.getTime()>t2.getTime()) return 1;
            if (t1.getTime()<t2.getTime()) return -1;
            return 0;
        }
    </script>
    <script>
        $('img').on('load', function() {
            $('img').css('background', 'none');
        });

        $(document).ready(function() {

            $('.parent_of_img').css('width', $('.parent_of_img img').width());

            $('.parent_of_img img')
                .parent()
                .zoom({
                    magnify: 2,
                    target: $('.contain').get(0)
                });
        });

        // modal carousel
        $('.modal-carousel').owlCarousel({
            items: 1,
            loop: true,
            center: true,
            margin: 20,
            dots: true,
            nav: true,
            autoplayHoverPause: true,

        });

        $('.modal-close-icon').on('click', function() {
            $('.custom-modal').css('transform', 'scale(0)');
        });
    </script>
    <script>
        // $(document).on('oninput', '.search-input', function() {

        //     $('.search-input').css('background', '#fff');
        // })
    </script>
    <script>
        $(document).on('click', '.modal-plus-icon', function() {
            $('.custom-modal').css('transform', 'scale(1)');
        })
    </script>

    <script>
        $(document).on('click', '.partnerModals', function() {
            $('#partnerModal').show();
        })
        $('#partnerColse').on('click', function() {
            $('#partnerModal').hide();
        })
    </script>
    <script>
        $(".owl-prev").html('<i class="fa fa-chevron-left"></i>');
        $(".owl-next").html('<i class="fa fa-chevron-right"></i>');
    </script>
    <script>
        @if (Session::has('update'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('update') }}");
        @endif

        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif
        @if (Session::has('success'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('success') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    <script>
        $('.cart-open').on('click', function() {
            $('.dropdown-cart').slideToggle();
        })
    </script>


    {{-- partner modal data --}}

    <script>
        function PatnerModel(id) {
            var url = '/single-partner-details/' + id;
            $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                success: function(res) {
                    $('#partnerName').text(res.name);
                    $('#partnerDetails').text(res.details);
                    $('#partnerImage').attr('src', res.image);
                }
            })
        }
    </script>
     
    {{-- product modal --}}
    <script>
        function productModal(id) {
            var url = '/modal-single-product/' + id;
            $.ajax({
                url: url,
                type: "get",
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    var url = "/cartAdd/" + id;
                    var url2 = "/checkout-cart/" + id;
                    $('#modal-form').attr('action', url);
                    $('#product_name').text(res.name);
                    $('#product_id').val(res.id);
                    let rate = '{{currency_rate()}}';
                    let price = parseFloat(rate * res.price).toFixed(2);
                    $('#price').text(price);
                    $('#category').text(res.category.name);
                    console.log(res.category.name)
                    $('#checkout-form').attr('action', url2);
                    $('.zoomImg').attr('src', '/uploads/products/original/' + res.main_image);
                    var data = '';
                    var color = '<?php echo $colors; ?>'
                    var colors = res.color_id;
                    $('#color').val(colors[0]);
                    var arry = colors.split(",");
                    let checked = '';
                    $.each(arry, function(key, value) {
                        $.each(JSON.parse(color), function(key2, value2) {
                            if (key == 0) {
                                checked = 'checked'
                            }
                            if (value2.id == value) {
                                data +=
                                    `<input type="radio" name="color_id" value="${value2.id}" label="" class="size-field" style="background:${value2.code};"  ` +
                                    checked + `>`;
                            }
                            checked = ''
                        });
                    });
                    $('#color-part').html(data);
                    var data = '';
                    var size = '<?php echo $sizes; ?>';
                    var sizes = res.size_id;
                    $('#size').val(sizes[0]);
                    var arry2 = sizes.split(",");
                    $.each(arry2, function(key, value) {
                        $.each(JSON.parse(size), function(key2, value2) {
                            if (key == 0) {
                                checked = 'checked'
                            }
                            if (value2.id == value) {
                                data +=
                                    `<input type="radio" name="size_id" value="${value2.id}" label="${value2.name}" class="size-field size" ` +
                                    checked + `>`;
                            }
                            checked = ''

                        });
                    });
                    $('#size-part').html(data);
                }
            });
        }
    </script>
    
    <script>
        // color and size javascript
        $('.color').val();
        $('#color').val($('.color').val());
        $('.size').val();
        $('#size').val($('.size').val());

        $(document).on('click', '.size', function() {
            var val = $(this).val();
            $('#size').val(val);
        })
        $(document).on('click', '.color', function() {
            var val = $(this).val();
            $('#color').val(val);
        })

        $(document).on('change', '.quantity', function() {
            var val = $(this).val();
            $('#quantity').val(val);
        })
    </script>
    <script src="{{ asset('website/js/jquery.jscroll.min.js') }}"></script>
    <script type="text/javascript">
        $('ul.pagination').hide();
        $(function() {
            $('.scrolling-pagination').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.scrolling-pagination',
                callback: function() {
                    $('ul.pagination').remove();
                }
            });
        });
    </script>

    <script type="text/javascript">
        var baseUri = "{{ url('/') }}";
        // $('#keyword').typeahead({
        //     minLength: 1,
        //     source: function(keyword, process) {
        //         console.log(process);
        //         return $.get(`${baseUri}/get_suggestions/${keyword}`, function(data) {
        //             return process(data);
        //         });
        //     },

        //     updater: function(item) {
        //         $(location).attr('href', '/search?q=' + item);
        //         return item;
        //     }

        // });

        $(document).ready(function() {

            $('#keyword').autocomplete({
                source: "/get_suggestions",
                minLength: 1,
                select: function(event, ui) {
                    $('#keyword').val(ui.item.value);
                }
            })
            // .data('ui-autocomplete')._renderItem = function(ul, item) {
            //     return $("<li class='ui-autocomplete-row'></li>")
            //         .data("item.autocomplete", item)
            //         .append(item.label)
            //         .appendTo(ul);
            // };

        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).on('submit', '#WishList', function(e) {
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
                    CountWislist();
                    toastr.success(res.title);
                },
                error: function(error) {
                    alert('opps faild to added wishlist please login first')
                    location.replace('/customer-login')
                }
            })

        })
    </script>
    
    <script>
        $('.product-carousel').owlCarousel({
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            // smartSpeed:250,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        })
    </script>
    <script>
        function CountWislist() {
            $.ajax({
                url: "{{ route('wishlist.count') }}",
                type: "get",
                dataType: "json",
                success: function(res) {
                    $('#wishlist').text(res);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        CountWislist();
    </script>
    {{-- max and min price slider --}}

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v15.0" nonce="0H29YH2e"></script>
</body>

</html>
