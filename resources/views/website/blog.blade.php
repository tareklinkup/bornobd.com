@extends('layouts.website')
@push('website-css')
    <link rel="stylesheet" href="{{ asset('website') }}/css/cart.css">
@endpush
@section('website-content')

    <!-- cart-section  section start-->
    <section class="news-section py-3">
        <div class="container custom-container">
            <div class="section-title">
                <h3>What's Happening New</h3>
            </div>
            <div class="row">
                @foreach ($blogs as $item)
                <div class="col-lg-3 mb-3 col-6 ">
                    <div class="news-box">
                        <a href="{{route('blog.details',$item->slug)}}" class="text-decoration-none text-black ">
                            <div class="card w-100">
                                <img src="{{asset($item->image)}}" class="card-img-top" alt="..." style="height: 160px;">
                                <div class="card-body">
                                   <div class="news-top d-flex">
                                       <div class="category-name-news">Digital Shop</div>
                                       <div class="date ms-auto">{{date('Y-m-d', strtotime($item->date))}}</div>
                                   </div>
                                   <h5 class="text-danger">{{$item->title}}</h5>
                                  <p class="card-text">
                                    {!!Str::limit($item->description, 150)!!}
                                  </p>
                                </div>
                              </div>
                        </a>
                    </div>
                </div> 
                @endforeach
               
            </div>
            
        </div>
    </section>
    @push('website-js')

      
       
    @endpush
@endsection
