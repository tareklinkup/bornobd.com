@extends('layouts.website')
@section('title', 'Hot Deal')
@push('website-css')
    <style>
        .range-slider {
            width: 100%;
            text-align: center;
            position: relative;
            font-size: 14px;
            font-weight: 500;
        }

        .range-slider .rangeValues {
            display: block;
        }

        input[type=range] {
            -webkit-appearance: none;
            border: 1px solid white;
            width: 100%;
            position: absolute;
            left: 0;
        }

        input[type=range]::-webkit-slider-runnable-track {
            width: 100%;
            height: 5px;
            background: #ddd;
            border: none;
            border-radius: 3px;
        }

        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            border: none;
            height: 12px;
            width: 12px;
            border-radius: 50%;
            background: #000;
            margin-top: -4px;
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        input[type=range]:focus {
            outline: none;
        }

        input[type=range]:focus::-webkit-slider-runnable-track {
            background: #ccc;
        }

        input[type=range]::-moz-range-track {
            width: 100%;
            height: 5px;
            background: #ddd;
            border: none;
            border-radius: 3px;
            max-width: 100%;
        }

        input[type=range]::-moz-range-thumb {
            border: none;
            height: 16px;
            width: 16px;
            border-radius: 50%;
            background: #000;
        }

        /*hide the outline behind the border*/
        input[type=range]:-moz-focusring {
            outline: 1px solid white;
            outline-offset: -1px;
        }

        input[type=range]::-ms-track {
            width: 100%;
            height: 5px;
            /*remove bg colour from the track, we'll use ms-fill-lower and ms-fill-upper instead */
            background: transparent;
            /*leave room for the larger thumb to overflow with a transparent border */
            border-color: transparent;
            border-width: 6px 0;
            /*remove default tick marks*/
            color: transparent;
            z-index: -4;
            max-width: 100%
        }

        input[type=range]::-ms-fill-lower {
            background: #777;
            border-radius: 10px;
        }

        input[type=range]::-ms-fill-upper {
            background: #ddd;
            border-radius: 10px;
        }

        input[type=range]::-ms-thumb {
            border: none;
            height: 10px;
            width: 10px;
            border-radius: 50%;
            background: #000;
        }

        input[type=range]:focus::-ms-fill-lower {
            background: #888;
        }

        input[type=range]:focus::-ms-fill-upper {
            background: #ccc;
        }

    </style>
@endpush
@section('website-content')

    <form action="" id="filter">
        <div id="filter-input">
            <div class="custom-container">
                <nav class="border pt-2 px-3 my-3 bg-light d-flex vertical-align" style="" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                        <li class="breadcrumb-item active fw-bolder" aria-current="page">Hot Deal</li>
                    </ol>
                    <div class="left-filter vertical-align text-end ms-auto">

                        <select name="input_value" class="left-filter-field ">
                            <option value=" ">Select Sort type</option>
                            <option value="1">Popular</option>
                            <option value="2">Price:Low to high</option>
                            <option value="3">Price:High to low</option>
                        </select>

                    </div>
                </nav>
            </div>

            <section class="product-list mt-0">
                <div class="custom-container mt-3">
                    <div class="row">
                        <div class="col-lg-3 ">

                            <div class="card product-sidebar p-3 mb-4">

                                {{-- <div class="mb-5">
                                <select name="input_value" class="left-filter-field ">
                                    <option value=" ">Select Sort type</option>
                                    <option value="1">Popular</option>
                                    <option value="2">Price:Low to high</option>
                                    <option value="3">Price:High to low</option>
                                </select>
                            </div> --}}
                                <div class="sidebar-secction">
                                    <h4 class="sidebar-title pb-1">Filter By Price Range</h4>
                                    <div class="range-slider pt-3">
                                        <span class="rangeValues"></span>
                                        <input value="{{ $min }}" name="min_price" min="{{ $min }}"
                                            max="{{ $max }}" step="1" type="range">
                                        <input value="{{ $max }}" name="max_price" min="{{ $min }}"
                                            max="{{ $max }}" step="1" type="range">
                                        {{-- <input class="mt-3" type="submit"> --}}
                                    </div>
                                </div>
                                <div class="sidebar-secction">
                                    <h4 class="sidebar-title pb-1">Filter By Size</h4>
                                    <select name="size_id" class="form-control">
                                        <option value=" " disabled selected>Select Sort type</option>
                                        @foreach ($sizes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="sidebar-secction">
                                    <h4 class="sidebar-title pb-1">Filter By Color</h4>
                                    <select name="color_id" class="form-control">
                                        <option value=" ">Select Sort type</option>
                                        @foreach ($colors as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sidebar-secction">
                                    <h4 class="sidebar-title pb-1">Filter Category</h4>
                                    <ul class="category-sidebar" id="nav_accordion">
                                        @foreach ($categorylist as $item)
                                            @if ($item->subcategory->count() == 0)
                                                <li class="nav-item"><a class="nav-link"
                                                        href="{{ route('categroy.product', $item->slug) }}">{{ $item->name }}</a>
                                                </li>
                                            @endif
                                            @if ($item->subcategory()->count() > 0)
                                                <li class="nav-item">
                                                    <a class="nav-link sidebar-link" data-bs-toggle="collapse"
                                                        data-bs-target="#menu_item{{ $item->id }}"
                                                        href="{{ route('categroy.product', $item->slug) }}">
                                                        {{ $item->name }}

                                                        <span class="angle-right"><i
                                                                class="fas fa-angle-right"></i></span>

                                                    </a>
                                                    {{-- @if ($item->subcategory()->count() > 0) --}}
                                                    <ul id="menu_item{{ $item->id }}" class="mb-0 collapse"
                                                        data-bs-parent="#nav_accordion">
                                                        @foreach ($item->subcategory as $subcate)
                                                            <li> <a
                                                                    href="{{ route('subcategory.product', $subcate->slug) }}">{{ $subcate->name }}
                                                                </a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>

                                <div class="col-lg-9">
                                    <div class="scrolling-pagination" id="default-product">
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
                                            {{ $product->links() }}
                                        </div>
                                    </div>
                                    <div class="">
                                        <div id="data-row" class="row">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </form>
    {{-- </form>
    </section> --}}
@endsection
@push('website-js')
    <script>
        $(document).ready(function() {
            $(document).on("change", "#filter-input", function(e) {
                e.preventDefault();
                var data = $('#filter').serialize();
                var url = "{{ route('filter.product') }}";
                $.ajax({
                    url: url,
                    method: 'get',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(res) {

                        console.log(res);
                        if (res) {
                            $('#default-product').hide();
                        }
                        var data = '';

                        $.each(res, function(key, value) {

                            console.log(value.slug);
                            data += '<div class="col-md-3 col-6">'
                            data += '<div class="product-single">'
                            data += '<div class="product-img">'

                            var urlDetails = '/product-details/' + value.slug;

                            data += ' <a href="' + urlDetails + '">'
                            var base_url = ' <?php echo route('home'); ?>';
                            var img1 = '/uploads/products/thumbnail/' + value
                                .thumb_image;
                            data += '<img src="' + img1 +
                                '" alt="" class="w-100 front-img">'
                            console.log(img1);
                            if (typeof value.product_image[0] != 'undefined' && value.product_image[0] !== null) {
                                var img2 = '/uploads/products/thumbnail/' + value
                                    .product_image[0].other_mediam_image;
                                 
                                data += '<img src="' + img2 +
                                    '"  alt="" class="w-100 back-img">'
                            }


                            data += ' </a>'
                            data +=
                                ' <i class="fa-solid fa-plus modal-plus-icon" onclick="productModal(' +
                                value.id + ')"></i>'
                            data += '</div>'
                            data += '<div class="product-content">'
                            data += '<a href="' + urlDetails +
                                '"><h5 class="m-0 product-name">' + value.name +
                                '</h5></a>'
                            data += '<p> {{currency_sign()}}'+value.currency_amount+'</p>';
                            data += '</div></div></div>'
                        })
                        $('#data-row').html(data);
                        // var data2 = '';
                    }
                });

            });
        })
    </script>
    <script>
        function getVals() {
            // Get slider values
            let parent = this.parentNode;
            let slides = parent.getElementsByTagName("input");
            let slide1 = parseFloat(slides[0].value);
            let slide2 = parseFloat(slides[1].value);
            // Neither slider will clip the other, so make sure we determine which is larger
            if (slide1 > slide2) {
                let tmp = slide2;
                slide2 = slide1;
                slide1 = tmp;
            }

            let rate = '{{currency_rate()}}';
            slide1 = parseFloat(rate * slide1).toFixed(2);
            slide2 = parseFloat(rate * slide2).toFixed(2);

            let displayElement = parent.getElementsByClassName("rangeValues")[0];
            displayElement.innerHTML = "{{currency_sign()}}" + slide1 + " - {{currency_sign()}}" + slide2;
        }

        window.onload = function() {
            // Initialize Sliders
            let sliderSections = document.getElementsByClassName("range-slider");
            for (let x = 0; x < sliderSections.length; x++) {
                let sliders = sliderSections[x].getElementsByTagName("input");
                for (let y = 0; y < sliders.length; y++) {
                    if (sliders[y].type === "range") {
                        sliders[y].oninput = getVals;
                        // Manually trigger event first time to display values
                        sliders[y].oninput();
                    }
                }
            }
        }
    </script>
@endpush
