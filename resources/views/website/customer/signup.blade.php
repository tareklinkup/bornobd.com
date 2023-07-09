
@extends('layouts.website')
@section('title', 'Customer Register')
@section('website-content')

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-12">
                <div class="shadow px-5 py-3">
                    <form action="{{route('customer.register')}}" method="post">
                        @csrf
                        <h2 class="text-center login-title">Registration</h2>
                        <div class="form-group my-1">
                          
                            <input type="text" name="name" value="{{old('name')}}" placeholder="Enter Name" class="form-control mt-3 login-input @error('name') is-invalid @enderror" autocomplete="off" >
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group my-1">
                            <input type="text" name="phone" value="{{old('phone')}}" placeholder="Enter Phone" class="form-control login-input mt-3  @error('phone') is-invalid @enderror" autocomplete="off" >
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group my-1">
                            <textarea name="address" id="" class="form-control login-input @error('address') is-invalid @enderror" rows="2" placeholder="Enter Your Address"></textarea>
                            {{-- <textarea name="address" class="form-control login-input mt-3  @error('address') is-invalid @enderror" cols="30" rows="2" placeholder = "Enter comments here"> </textarea> --}}
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group my-1">
                         
                            <input type="password" name="password" placeholder="Enter Password" class="form-control login-input mt-3  @error('password') is-invalid @enderror" autocomplete="off">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group my-1">
                           
                            <input type="password" name="cpassword" placeholder="Confirm Password" class="form-control login-input mt-3" autocomplete="off">
                        </div>
                        <div class="mt-3 text-center">
                            {{-- <input type="submit" class="btn btn-danger" value="Sign Up">
                            <a href="{{route('')}}" class="btn btn-success ms-auto">Login</a> --}}
                            <input type="submit" class="login-btn" value="Register">
                            <p class="login-text">Already have an account? <a href="{{route('customer.login')}}">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



@endsection
