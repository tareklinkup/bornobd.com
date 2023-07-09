@extends('layouts.website')
@section('title', 'Home')
@section('website-content')
    <style>

    </style>

    
    <!-- trending section -->
    {{-- draggble btn --}}
    <div id="draggable" class="popUpOpen" >
        <img class="w-100" style="" src="{{ asset($content->pop_up_icon) }}" alt="">
    </div>
    <section class="">
        <div id="carouselExampleControls" class="carousel slide" style="height: 600" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($slider as $key => $item)
                    <div class="carousel-item  {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ 'uploads/banner/' . $item->image }}" class="d-block w-100 slider-height" alt="...">
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section class="pb-1 pt-4">
        <div class="container">
            <div class="row">
                @foreach ($bigcategory as $item)
                    <div class="col-lg-6 col-md-6 col-6">
                        <div class="trend-box">
                            <a href="{{ route('categroy.product', $item->slug) }}"><img loading="lazy"
                                    src="{{ asset('uploads/category/original/' . $item->image) }}" alt=""
                                    class="trend-img"></a>
                            <div class="trend-button-position">
                                <a href="{{ route('categroy.product', $item->slug) }}"
                                    class="btn trend-button">{{ $item->name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- close trending section -->

    <!-- category section -->
    <section class="py-4" id="DDD">
        <div class="container">
            <div class="row row-cols-3 row-cols-md-3 g-4">
                @foreach ($smallCategory as $item)
                    <div class="col">
                        <div class="category-box">
                            <a href="{{ route('categroy.product', $item->slug) }}"><img
                                    src="{{ asset('uploads/category/thumbnail/' . $item->thumbimage) }}" alt=""
                                    class="category-img"></a>
                            <div class="category-button-position">
                                <a href="{{ route('categroy.product', $item->slug) }}"
                                    class="btn trend-button">{{ $item->name }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- close category section -->

    <!-- comfortable section -->
    <section class="py-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    
                        <div class="row g-0">
                            <div class="col-md-8">
                                <a href="{{ $middleAdd->title }}"> <img src="{{ 'uploads/ad/' . $middleAdd->image }}"
                                        class="w-100" alt="..."></a>
                            </div>
                            <div class="col-md-4 align-self-center">
                                <div class="card-body text-center ps-md-5 ps-2">
                                    <h3 class="card-title text-center fw-bolder text-capitalize"> Comfortable <br> In <br> Everything</h3>
                                    <a href="{{ route('product.list') }}" class="btn trend-button"
                                        style="font-size: 22px; background:red">More</a>
                                </div>
                            </div>
                        </div>
                   
                </div>
            </div>
        </div>
    </section>
    <!-- close comfortable section -->

    <!-- Hot Deal section -->
    <section class="py-4">
        <div class="container">
            <div class="custom-border-bottom">
                <h3 class="text-center title-text">Hot Deal</h3>
            </div>
           
            <div class="container mt-3">
                <div class="row">
                    @foreach ($product as $item)
                    <div class="col-md-2 col-6">
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

            </div>
            {{-- {{ $product->links() }} --}}
        </div>

    </section>
    <!-- Hot Deal section -->

    <!-- media section -->
    <section class="py-4" id="videMidea" style="display: none">
        <div class="container">
            <div class="custom-border-bottom">
                <h3 class="text-center title-text">Media</h3>
            </div>
            <div class="row row-cols-2 row-cols-md-4 mt-4">
                @foreach ($video as $item)
                    <div class="col">
                        <iframe width="100%" height="220" src="{{ $item->youtube_link }}" title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- close media section -->

    <!-- Feature section -->
    <section class="py-4">
        <div class="container">
            <div class="custom-border-bottom">
                <h3 class="text-center title-text">Feature Product</h3>
            </div>
           
            <div class="container mt-3">
                <div class="row">
                    @foreach ($feature_product as $item)
                    <div class="col-md-2 col-6">
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
            </div>
        </div>

    </section>
    <!-- Hot Deal section -->

    <!-- summer collection -->
    <section class="py-2"  >
        <div class="container">
            <div class="row ">
                <div class="col-lg-6 col-md-6 col-6 ">
                    <a href="{{ route('collection_one.product') }}">
                        <img src="{{ asset('uploads/collection/large/' . $content->is_collection_img_1) }}" alt=""
                            class="collection-img rounded">
                        <h5 class="text-center title-text fw-bolder mt-2">{{ $content->is_collection_title_1 }}</h5>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-6 ">
                    <a href="{{ route('collection_two.product') }}">
                        <img src="{{ asset('uploads/collection/large/' . $content->is_collection_img_2) }}" alt=""
                            class="collection-img rounded">
                        <h5 class="text-center title-text fw-bolder mt-2">{{ $content->is_collection_title_2 }}</h5>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- close summer collection -->

    <!-- New Arrival section -->
    <section class="py-4">
        <div class="container">
            <div class="custom-border-bottom">
                <h3 class="text-center title-text">New Arrival</h3>
            </div>
           
            <div class="container mt-3">
                <div class="row">
                    @foreach ($new_arrival as $item)
                    <div class="col-md-2 col-6">
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
            </div>
        </div>

    </section>
    <!-- New Arrival section -->

    <!-- Trending Product section -->
    <section class="py-4">
        <div class="container">
            <div class="custom-border-bottom">
                <h3 class="text-center title-text">Trending Product</h3>
            </div>
           
            <div class="container mt-3">
                <div class="row">
                    @foreach ($tranding_product as $item)
                    <div class="col-md-2 col-6">
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
            </div>
        </div>

    </section>
    <!-- Tranding Product section -->

    <!-- ad section -->
    <section class="py-4"  >
        <div class="container-fluid">
            <div class="row g-0">
                <div class="col">
                    @isset($bigAdd)
                        <a href="{{ $bigAdd->title }}">
                            <img src="{{ 'uploads/ad/' . $bigAdd->image }}" alt="{{ $bigAdd->title }}" class="ad-image">
                        </a>
                    @endisset
                </div>
            </div>
        </div>
    </section>
    <!-- close ad section -->



    <Section class="py-4">
        <div class="container">
            <div class="row mx-auto">
                <div class="col-lg-4 offset-lg-2">
                    <div class="card h-100">
                        @isset($halfAdd)
                            <a href="{{ $halfAdd->title }}"><img class="w-100"
                                    src="{{ 'uploads/ad/' . $halfAdd->image }}" alt="{{ $halfAdd->title }}"
                                    class="ad-image"></a>
                        @endisset
                    </div>
                </div>
                <style>
                    .h_ifrem iframe {
                        width: 100% !important;
                        height: 100% !important;
                    }

                </style>
                <div class="col-lg-4">
                    <div class="card border-0 h-100 h_ifrem">
                        <div class="fb-page" data-href="https://www.facebook.com/Bornon.com.bd/" data-tabs="timeline" data-width="" data-height="400" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Bornon.com.bd/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Bornon.com.bd/">বর্ণন-Bornon</a></blockquote></div>
                        {{-- <iframe class="" height="400" width="100%"
                            src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Frangbangladesh&tabs=timeline&width=500&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                            style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="false"
                            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe> --}}
                    </div>
                </div>
            </div>
        </div>
    </Section>
    <!-- brand section -->
    <section class="py-4 bg-light" >
        <div class="container ">
            <div class="row row-cols-2 row-cols-md-5 row-cols-lg-10 text-center" >
                @foreach ($partner as $item)
                    {{-- <div class="col text-center  partnerModals" style="" onclick="PatnerModel({{ $item->id }})"> --}}
                        <a href="{{ route('partnerPage.details', $item->id) }}" target="_blank">
                        <img src="{{ asset($item->image) }}" alt=""
                            class="brand-logo rounded">
                        </a>
                @endforeach
            </div>
        </div>
    </section>

    <div style="position: fixed; right:0; bottom:50px; ">
        <a id="VidePlayer"> <img class="w-100 gifbtn_video" style="height:60px" src="{{ asset('tv.gif') }}" alt=""></a>
    </div>
    <!---- product modal end--->
    <!-- close brand section -->
    @push('website-js')
   
        <script>
            $('#VidePlayer').on('click', function() {
            $("#videMidea").attr("style", "display:block")
            $('html, body').animate({
                scrollTop: $("#videMidea").offset().top
            }, 1000);
        });
        </script>
  
    @endpush
@endsection
