<!-- navbar -->
<?php ?>

<?php

$baseUrl = URL::to('/');
$homeUrl = URL::to('/home');
$currentUrl = url()->current();

?>
<?php if($baseUrl ==$currentUrl || $homeUrl == $currentUrl) { ?>

<div class="fixed-menu">

    <?php }else{ ?>

    <div style="">

        <?php } ?>


        <header class="main-nav " style="">
            <div class="top-header py-1 text-dark">
                <?php if($baseUrl == $currentUrl || $homeUrl == $currentUrl) { ?>
                <div class="container">
                    <?php }else{ ?>
                    <div class="custom-container">
                        <?php } ?>

                        <div class="row  sm-aling pt-1">
                            <div class="col-lg-3 col-12 text-center">
                                <?php if($baseUrl ==$currentUrl || $homeUrl == $currentUrl) { ?>
                                <a class="" href="{{ route('home.index') }}">
                                    <?php }else{ ?>
                                    <a style="" class="" href="{{ route('home.index') }}">
                                        <?php } ?>
                                        <img class="logo-image" src="{{ asset($content->logo) }}" alt="logo"></a>

                            </div>
                            <div class="col-lg-9 col-12">
                                <div class="vertical-align sm-align">
                                    <div class=" search-part  pt-2 pb-0">
                                        <form class="d-flex" action="{{ route('search') }}" method="GET">
                                            <?php if($baseUrl ==$currentUrl || $homeUrl == $currentUrl) { ?>
                                            <input type="text" name="q" id="keyword"
                                                class="form-control search-bar keyword search-input"
                                                placeholder="Search..." autocomplete="off">
                                            <button type="submit" class="btn search-btn"><i
                                                    class="fa-solid fa-search"></i></button>
                                            <?php }else{ ?>
                                            <input type="text" name="q" id="keyword"
                                                class="form-control search-bar keyword  search-input-other"
                                                placeholder="Search..." autocomplete="off">
                                            <button type="submit" class="btn search-btn-other"><i
                                                    class="fa-solid fa-search"></i></button>
                                            <?php } ?>

                                        </form>
                                    </div>
                                    <div class=" my-auto ms-auto">
                                        <?php if($baseUrl ==$currentUrl || $homeUrl == $currentUrl) { ?>
                                        <div class="float-end top-icon d-flex">
                                            <?php }else{ ?>
                                            <div class="float-end  top-icon-otherpage d-flex">
                                                <?php } ?>

                                                <a class="" href="{{ url('customer-dashboard') }}">
                                                    <i class="fa-regular fa-heart"></i>
                                                    <span
                                                        class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-info nav-pill-font"
                                                        id="wishlist">
                                                    </span>
                                                </a>
                                                <a href="{{ route('customer.login') }}"> <i
                                                        class="fa-regular fa-user"></i></a>

                                                <a class="dropdown cart-open" href="#"><i
                                                        class="fas fa-cart-arrow-down"></i>
                                                    <span
                                                        class="position-absolute top-25 start-75 translate-middle badge rounded-pill bg-info nav-pill-font ">{{ \Cart::getContent()->count() }}</span>
                                                </a>
                                                <ul class="dropdown-cart bg-transparent border-0">
                                                    <div class="card cart-background">
                                                        <div class="card-header d-flex justify-content-between">
                                                            <a href="" class="text-uppercase text-dark"
                                                                style="font-size: 14px">
                                                                {{ \Cart::getContent()->count() }}
                                                                item</a>
                                                            <a href="{{ route('cart.list') }}"
                                                                class="text-uppercase text-dark"
                                                                style="font-size: 14px">view cart</a>
                                                        </div>
                                                        <div class="card-body cart-list-dropdown px-0">
                                                            @foreach (\Cart::getContent() as $item)
                                                                <li>
                                                                    <div class="vertical-align">
                                                                        <span class="cart-product-name mx-1 text-dark">
                                                                            <a href="#">{{ $item->name }}</a>
                                                                            <p
                                                                                class="cart-product-price mx-1 text-dark">
                                                                                {{ $item->quantity }} X
                                                                                {{ currency_sign() }}{{ currency_amount($item->price) }}
                                                                            </p>
                                                                        </span>
                                                                        <span class="ms-auto">
                                                                            <a href="#">
                                                                                <img src="{{ asset('uploads/products/small/' . $item->attributes->image) }}"
                                                                                    alt="" class="w-100">
                                                                            </a>
                                                                        </span>
                                                                        <span class="mx-2">
                                                                            <a
                                                                                href="{{ route('cart.remove', $item->id) }}">
                                                                                <div class="cart-product-remove-icon">
                                                                                    <i class="fa-solid fa-xmark"></i>
                                                                                </div>
                                                                            </a>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </div>
                                                        <div class="card-footer py-0">
                                                            <a href="{{ route('checkout') }}"
                                                                class="btn btn-light text-dark btn-ecomm w-100">Checkout</a>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <section class="">
                                            <nav class="navbar header-nav navbar-expand-md py-0">
                                                <div class="custom-container px-0">
                                                    {{-- <a class="navbar-brand" href="{{ route('home') }}"><img
                                                    src="{{ asset($content->logo)}}" alt="logo"
                                                    class="logo-img"></a> --}}
                                                    <button class="navbar-toggler" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#navbarSupportedContent"
                                                        aria-controls="navbarSupportedContent" aria-expanded="false"
                                                        aria-label="Toggle navigation">
                                                        <span class="bg-secondary px-2 rounded pb-1">
                                                            <i class="fa-solid fa-bars text-white "></i>
                                                        </span>
                                                    </button>


                                                    <?php if($baseUrl ==$currentUrl || $homeUrl == $currentUrl) { ?>

                                                    <div class="collapse navbar-collapse custom-navbar"
                                                        id="navbarSupportedContent">

                                                        <?php }else{ ?>

                                                        <div class="collapse navbar-collapse mt-3 custom-navbar-otherpage"
                                                            id="navbarSupportedContent">

                                                            <?php } ?>

                                                            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                                                                <li class="nav-item">
                                                                    <a class="nav-link active fw-bold"
                                                                        aria-current="page"
                                                                        href="{{ route('home.index') }}">Home</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link active fw-bold"
                                                                        aria-current="page"
                                                                        href="{{ route('product.list') }}">All
                                                                        Product</a>
                                                                </li>
                                                                {{-- {{ $categorylist }} --}}
                                                                {{-- <li class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle" onclick="openNav()" href="#" id="navbarDropdown"
                                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            Category
                                                        </a>
                                                    </li> --}}

                                                                <li class="nav-item dropdown">
                                                                    <a class="nav-link dropdown-toggle" href="#"
                                                                        id="navbarDropdown" role="button"
                                                                        data-bs-toggle="dropdown"
                                                                        aria-expanded="false">
                                                                        Category
                                                                    </a>
                                                                    <ul class="dropdown-menu"
                                                                        aria-labelledby="navbarDropdownMenuLink">
                                                                        @foreach ($categorylist as $item)
                                                                            <li>
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('categroy.product', $item->slug) }}">
                                                                                    {{ $item->name }}
                                                                                    @if ($item->subcategory->count() > 0)
                                                                                        &raquo;
                                                                                    @endif
                                                                                </a>
                                                                                @isset($item->subcategory)
                                                                                    @if ($item->subcategory->count() > 0)
                                                                                        <ul
                                                                                            class="dropdown-menu dropdown-submenu">
                                                                                            @foreach ($item->subcategory as $subcat)
                                                                                                <li>
                                                                                                    <a class="dropdown-item"
                                                                                                        href="{{ route('subcategory.product', $subcat->slug) }}">{{ $subcat->name }}
                                                                                                        @if ($subcat->subSubCategory->count() > 0)
                                                                                                            &raquo;
                                                                                                        @endif
                                                                                                    </a>

                                                                                                    @if (isset($subcat->subSubCategory))
                                                                                                        @if ($subcat->subSubCategory->count() > 0)
                                                                                                            <ul
                                                                                                                class="dropdown-menu dropdown-submenu">
                                                                                                                @foreach ($subcat->subSubCategory as $clildname)
                                                                                                                    <li>
                                                                                                                        <a class="dropdown-item"
                                                                                                                            href="{{ route('sub.subcategory.product', $clildname->slug) }}">{{ $clildname->name }}
                                                                                                                            @if ($clildname->anotherCategory->count() > 0)
                                                                                                                                &raquo;
                                                                                                                            @endif
                                                                                                                        </a>
                                                                                                                        @if (isset($clildname->anotherCategory))
                                                                                                                            @if ($clildname->anotherCategory->count() > 0)
                                                                                                                                <ul
                                                                                                                                    class="dropdown-menu dropdown-submenu">
                                                                                                                                    @foreach ($clildname->anotherCategory as $another)
                                                                                                                                        <li> <a href="{{route('another.category.product',$another->slug)}}"
                                                                                                                                                class="dropdown-item">
                                                                                                                                                {{ $another->name }}</a>

                                                                                                                                        </li>
                                                                                                                                    @endforeach
                                                                                                                                </ul>
                                                                                                                            @endif
                                                                                                                        @endif

                                                                                                                    </li>
                                                                                                                @endforeach
                                                                                                            </ul>
                                                                                                        @endif
                                                                                                    @endif
                                                                                                </li>
                                                                                            @endforeach

                                                                                        </ul>
                                                                                    @endif
                                                                                @endisset
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>

                                                                </li>


                                                                @foreach ($categoryMenu as $item)
                                                                    @if ($item->subcategory->count() == 0)
                                                                        <li class="nav-item">
                                                                            <a class="nav-link active fw-bold"
                                                                                aria-current="page"
                                                                                href="{{ route('categroy.product', $item->slug) }}">
                                                                                {{ $item->name }}
                                                                            </a>
                                                                        </li>
                                                                    @else
                                                                        <li class="nav-item dropdown">
                                                                            <a class="nav-link dropdown-toggle"
                                                                                href="#" id="navbarDropdown"
                                                                                role="button"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                {{ $item->name }}
                                                                            </a>
                                                                            <ul class="dropdown-menu"
                                                                                aria-labelledby="navbarDropdown">
                                                                                @foreach ($item->subcategory as $subcat)
                                                                                    <li>
                                                                                        <a class="dropdown-item"
                                                                                            href="{{ route('subcategory.product', $subcat->slug) }}">{{ $subcat->name }}</a>
                                                                                        <ul>
                                                                                            <li></li>
                                                                                        </ul>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                                <li class="nav-item">
                                                                    <a class="nav-link"
                                                                        href="{{ route('deal.product') }}">Hot
                                                                        Deals</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link"
                                                                        href="{{ route('trending.product') }}">Trending</a>
                                                                </li>
                                                                <li class="nav-item">
                                                                    <a class="nav-link"
                                                                        href="{{ route('newarrival.product') }}">New
                                                                        Arrival</a>
                                                                </li>

                                                            </ul>

                                                        </div>
                                                    </div>
                                            </nav>
                                        </section>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </header>




    </div>

    <div id="free_shipping">
        <h5>Free Shipping</h5>
        <h6 id="free_shipping_timer"></h6>
    </div>


    <!-- close navbar -->
