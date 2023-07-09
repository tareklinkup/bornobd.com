
@extends('layouts.website')
@section('title', 'Customer Login')
@section('website-content')

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
           
            <div class="col-md-4 shadow col-12">
                <div class="p-5">
                    <form action="{{route('customer.login.store')}}" method="post">
                        @csrf
                        <h2 class="text-center login-title">Login</h2>
                        <div class="form-group my-1 mb-3">
                            <input type="text" name="phone" placeholder="Enter Phone" class="form-control login-input @error('phone') is-invalid @enderror" autocomplete="off" >
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group my-1">
                            <input type="password" name="password" placeholder="Enter Password" class="form-control  login-input @error('password') is-invalid @enderror" autocomplete="off">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-3 text-center">
                            <input type="submit" class="login-btn" value="Login">
                            <p class="login-text">Don't have an account? <a href="{{route('customer.register.form')}}">Register</a></p>
                        </div> 
                    </form>
                </div>
            </div>
            {{-- <div class="col-7">
                <img src="{{ asset('website/img/login.webp') }}" class="w-100" alt="">
            </div> --}}
        </div>
    </div>
</section>
@endsection
