@extends('layouts.website')
@section('title', 'User dashboard')
@section('website-content')
    @push('website-css')
        <style>
            .select2 {
                width: 100%
            }
        </style>
    @endpush
    <div class="container">
        <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">User Account</li>
            </ol>
        </nav>
    </div>
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav user-panel-tab bg-light">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#dd">User Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#order">Order</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#wishlists">WishList</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#profile">Profile</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu1">Profile Edit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu2">Address</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#menu3">Change Password</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.logout') }}"
                            onclick="return confirm('Are you sure logout from dashboard!')">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="dashboard-right-side">
                    <div class="tab-content">
                        <div class="tab-pane active" id="dd">
                            <div class="card p-4">
                                <h3 class="title-text dasboard-dotted-border">My Dashboard</h3>
                                <p> Hello <span
                                        class="text-danger fw-bold text-uppercase">{{ Auth::guard('customer')->user()->name }}</span>,<br>
                                    From your account dashboard. you can easily check & view your recent orders, manage your
                                    shipping and billing addresses and edit your password and account details.
                                </p>
                            </div>
                        </div>
                        <div class="tab-pane  fade" id="profile">
                            <div class="card p-4 table-responsive">
                                <h3 class="title-text dasboard-dotted-border">Personal Information</h3>

                                <table class="my-table table  table-card-body">
                                    <tr>
                                        <td><b>Name:</b></td>
                                        <td>{{ Auth::guard('customer')->user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Username:</b></td>
                                        <td>{{ Auth::guard('customer')->user()->username }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Phone:</b></td>
                                        <td>{{ Auth::guard('customer')->user()->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Email:</b></td>
                                        <td> @isset(Auth::guard('customer')->user()->email)
                                                {{ Auth::guard('customer')->user()->email }}
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Address:</b></td>
                                        <td> @isset(Auth::guard('customer')->user()->address)
                                                {{ Auth::guard('customer')->user()->address }}
                                            @endisset
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Photo:</b></td>
                                        <td> @isset(Auth::guard('customer')->user()->profile_picture)
                                                <div id="preview">
                                                    <img src="{{ asset(Auth::guard('customer')->user()->profile_picture) }}"
                                                        alt="">
                                                </div>
                                            @endisset
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="wishlists">
                            <div class="card p-4 table-responsive">
                                <h3 class="title-text table-responsive dasboard-dotted-border">WishList</h3>

                                <table class="my-table table text-nowrap  table-card-body">
                                    @foreach ($wishlist as $item)
                                        <div class="vertical-align border-bottom mb-1">
                                            <span class="cart-product-name mx-1"><a
                                                    href="#">{{ $item->product->name }}</a>
                                                @if ($item->product->discount != '')
                                                    <p class="mb-1"> <span class="fw-bolder">Price:</span>
                                                        <span class="fw-bolder pe-3 text-danger">
                                                            {{ currency_sign() }}{{ currency_amount(calculateDiscount($item->product->price, $item->product->discount)) }}</span>
                                                        <span><del
                                                                class="text-danger">{{ $item->product->price }}Tk</del></span>
                                                    </p>
                                                @else
                                                    <p class="mb-1"><span class="fw-bolder">Price:</span>
                                                        {{ currency_sign() }}{{ currency_amount($item->product->price) }}
                                                    </p>
                                                @endif
                                            </span>
                                            <div class="color-size">
                                                <div class="mb-2">
                                                    @php
                                                        $color = explode(',', $item->product->color_id);
                                                    @endphp
                                                    @foreach ($colors as $c)
                                                        @foreach ($color as $key => $s)
                                                            @if ($key + 1 == $c->id)
                                                                <input type="radio" name="color_id"
                                                                    value="{{ $c->id }}"
                                                                    label="{{ $c->name }}" class="size-field color"
                                                                    {{ $key == 0 ? 'checked' : '' }}
                                                                    style="background:{{ $c->code }};width:50px"
                                                                    onclick="color(this)">
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>

                                                <div>
                                                    @php
                                                        $size = explode(',', $item->product->size_id);
                                                    @endphp
                                                    @foreach ($sizes as $s)
                                                        @foreach ($size as $key => $ss)
                                                            @if ($key + 1 == $s->id)
                                                                <input type="radio" name="size_id"
                                                                    value="{{ $s->id }}"
                                                                    label="{{ $s->name }}" onclick="size(this)"
                                                                    class="size-field size"
                                                                    {{ $key == 0 ? 'checked' : '' }}>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="ms-auto"><a href="#"><img
                                                        src="{{ asset('uploads/products/small/' . $item->product->small_image) }}"
                                                        alt="" class="w-100"></a></span>
                                            <span class="mx-2">
                                                <form action="{{ route('checkout.cart', $item->product->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="quantity" id="quantity" value="1">
                                                    <input type="hidden" name="size_id" id="size" value="">
                                                    <input type="hidden" name="color_id" id="color" value="">
                                                    <button type="submit" class="btn checkout-btn">Checkout</button>

                                                </form>
                                                <a type="submit" href="{{ route('wishlist.delete', $item->id) }}"
                                                    class="ms-2 btn btn-outline-danger mt-2"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </span>

                                        </div>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <!--- customer update part--->
                        <div class="tab-pane  fade" id="menu1">
                            <div class="card p-4">
                                <h3 class="title-text dasboard-dotted-border">Personal Information Edit</h3>

                                <form action="{{ route('auth.customer.update') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-md-6 col-12  py-1">
                                            <label for="">Name:</label>
                                            <input type="text" name="name"
                                                value="{{ Auth::guard('customer')->user()->name }}" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-12  py-1">
                                            <label for="">Username:</label>
                                            <input type="text" readonly
                                                value="{{ Auth::guard('customer')->user()->username }}"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-12  py-1">
                                            <label for="">Phone:</label>
                                            <input type="text" name="phone"
                                                value="{{ Auth::guard('customer')->user()->phone }}"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-12  py-1">
                                            <label for="">Email:</label>
                                            <input type="email" name="email"
                                                value="{{ Auth::guard('customer')->user()->email }}"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-12  py-1">
                                            <label for="">Photo:</label>
                                            <input type="file" name="profile_picture" id="image"
                                                class="form-control" onchange="readURL(this);">
                                            <span><button type="submt" class="btn update-btn mt-3"
                                                    value="Update">Update</button></span>
                                        </div>
                                        <div class="form-group col-lg-6 col-md-6 col-12">
                                            <span class="ms-auto"> <img src="" alt=""
                                                    id="previewImage"></span>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>


                        <!------ address bar section --->
                        <div class="tab-pane  fade" id="menu2">
                            <div class="card p-4">
                                <h3 class="title-text dasboard-dotted-border">Address Update</h3>

                                <div class="container">
                                    <form action="{{ route('auth.customer.address') }}" method="post">
                                        @csrf
                                        <div class="address-edit">
                                            {{-- <div class="form-group my-1">
                                            <label for="">Country:</label>
                                            <select name="country_id" class=" form-control @error('name') is-invalid @enderror">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{$country->id == Auth::guard('customer')->user()->country_id? 'selected':''}}>{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                                           @enderror
                                        </div> --}}
                                            {{-- <div class="form-group my-1">
                                                <label for="">District:</label>
                                                <select name="district_id" id="district_id"
                                                    class=" form-control @error('name') is-invalid @enderror">
                                                    @foreach ($districts as $district)
                                                        <option value="{{ $district->id }}"
                                                            {{ $district->id == Auth::guard('customer')->user()->district_id ? 'selected' : '' }}>
                                                            {{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('district_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}
                                            {{-- <div class="form-group my-1">
                                                <label for="">Upazila:</label>
                                                <select name="upazila_id" id="upazila_id"
                                                    class=" form-control @error('name') is-invalid @enderror">
                                                    @foreach ($upazilas as $upazila)
                                                        <option value="{{ $upazila->id }}"
                                                            {{ $upazila->id == Auth::guard('customer')->user()->upazila_id ? 'selected' : '' }}>
                                                            {{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('upazila_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}
                                            <div class="form-group my-1">
                                                <label for="">Address:</label>
                                                <textarea name="address" id="" class="form-control @error('name') is-invalid @enderror" rows="2">{{ Auth::guard('customer')->user()->address }}</textarea>
                                            </div>
                                            <input type="submit" class="btn update-btn" value="Update">
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane  fade" id="menu3">
                            <div class="card p-4">
                                <h3 class="title-text dasboard-dotted-border">Password Change</h3>

                                <div class="container">
                                    <form action="{{ route('password.update.customer') }}" method="post">
                                        @csrf
                                        <div class="form-group col-lg-12 col-md-6 col-12  py-1">
                                            <label for="">Current passowrd:</label>
                                            <input type="passowrd" name="currentPass" value=""
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-lg-12 col-md-6 col-12  py-1">
                                            <label for="">New Password:</label>
                                            <input type="passowrd" name="password" class="form-control">
                                        </div>
                                        <div class="form-group col-lg-12 col-md-6 col-12  py-1">
                                            <label for="">Confirm Password:</label>
                                            <input type="passowrd" name="password_confirmation" class="form-control">
                                        </div>
                                        <input type="submit" class="btn update-btn" value="Update">
                                    </form>
                                </div>
                            </div>

                        </div>
                        <!------ order  section start --->
                        <div class="tab-pane  fade" id="order">
                            <div class="card p-4">
                                <div class="vertical-align dasboard-dotted-border mb-3">
                                    <h3 class="title-text ">Order List</h3>
                                    {{-- {{  sum($reward->product->reward_point) }} --}}
                                    <?php $sum_tot_Price = 0; ?>
                                    @foreach ($order as $item)
                                        @if (isset($item->total_amount))
                                            <?php $sum_tot_Price += $item->total_amount; ?>
                                        @endif
                                    @endforeach
                                    <div class="ms-auto">Total Reward Point {{ $sum_tot_Price / 100 }}</div>
                                </div>

                                <div class="container table-responsive">
                                    <table class="w-100 table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Invoice No.</th>
                                                <th>Date</th>
                                                <th>Order Status</th>
                                                {{-- <th>Payment Status</th> --}}
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order as $item)
                                                <tr>
                                                    <td>{{ $item->invoice_no }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                                    <td>
                                                        @if ($item->status == 'p')
                                                            Pending
                                                        @elseif($item->status == 'on')
                                                            Processing
                                                        @elseif($item->status == 'w')
                                                            On the way
                                                        @elseif($item->status == 'd')
                                                            Delivered
                                                        @elseif($item->status == 'c')
                                                            Cancel
                                                        @endif
                                                    </td>
                                                    {{-- <td>Pending</td> --}}
                                                    <td>{{ currency_sign() }}{{ currency_amount($item->total_amount) }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('customer-indivisual.invoice', $item->id) }}"
                                                            class="btn btn-dagner"> <i
                                                                class="fas fa-file-invoice"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- order end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('website-js')
        <script>
            $(document).ready(function() {
                $('#country').select2();
                $('#district').select2();
            });
        </script>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage')
                            .attr('src', e.target.result)
                            .width(100);

                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            document.getElementById("previewImage").src =
                "{{ Auth::guard('customer')->user()->profile_picture ? Auth::guard('customer')->user()->profile_picture : '/noimage.png' }} ";
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
    @endpush
@endsection
