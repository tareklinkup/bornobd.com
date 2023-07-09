@extends('layouts.admin')
@section('title', 'Home')
@section('admin-content')
<main class="">
    <div class="container-fluid">
        <div class="heading-title p-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Dashboard</span>
        </div>
        <div class="row mt-3">
            <div class="dashboard-logo text-center pt-3 pb-4">
                <img class="border p-2" style="height:100px" src="{{ asset($content->logo) }}" alt="">
            </div>
            
            <div class="col-xl-2 col-md-6 " >
                <div class="card mb-3 dashboard-card ">
                    <a href="{{route('order.index')}}" class="card-body mx-auto">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-spinner admin_icon"></i> <span class="count">{{ $pending }}</span>
                        </div>
                        
                        <p class="dashboard-card-text">Pending Order</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{route('order.onProcess')}}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-project-diagram admin_icon"></i> <span class="count">{{ $process }}</span>
                        </div>
                         
                        <p class="dashboard-card-text">Processing Order</p>
                    </a>
                </div>
            </div>
          
            
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{route('order.way')}}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-road admin_icon"></i> <span class="count">{{ $way }}</span>
                        </div>
                        
                        <p class="dashboard-card-text"> On The way</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a class="card-body mx-auto" href="{{route('order.delivary')}}">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-truck admin_icon"></i> <span class="count">{{ $delivered }}</span>
                        </div>
                        <p class="dashboard-card-text">Delivered Order</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{route('sales.report')}}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-balance-scale-left admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Sales report</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{ route('product.index') }}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fab fa-product-hunt admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Product List</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{route('public.sms')}}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-envelope admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Public Message</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{ route('profile.edit') }}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-wrench admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Company Profile</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{route('sales.report')}}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-yin-yang admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Sales Reports</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{route('order.record')}}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-record-vinyl admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Order Record</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{ route('sms.sending') }}" class="card-body mx-auto">
                        <div class=" d-flex justify-content-center align-items-center">
                            <i class="fas fa-paper-plane admin_icon"></i>
                        </div>
                        <p class="dashboard-card-text">Send SMS</p>
                    </a>
                </div>
            </div>
            <div class="col-xl-2 col-md-6">
                <div class="card mb-3 dashboard-card">
                    <a href="{{ route('logout') }}">
                        <div class="card-body mx-auto text-center">
                            <div class=" d-flex justify-content-center align-items-center">
                                <i class="fa fa-sign-out-alt admin_icon"></i>
                            </div>
                            <p class="dashboard-card-text">Logout</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection