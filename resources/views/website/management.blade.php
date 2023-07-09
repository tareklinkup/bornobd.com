@extends('layouts.website')
@section('title', 'Our Management')
@section('website-content')

<div class="container">
    <nav class="border pt-2 px-3 my-3 bg-light" style="" aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item active fw-bolder" aria-current="page">Our Management</li>
        </ol>
    </nav>
</div>
<section>
    <div class="container">
        <div class="row">
            @foreach ($management as $item)
            <div class="col-12 py-3">
             <div class="card p-3">
                <div class="row">
                    <div class="col-lg-7">
                     <div class="management-content">
                        <h3 class="inner-page-heading">{{ $item->name }}</h3>
                        <h4 class="inner-page-heading">{{ $item->designation }}</h4>
                        <h5 class="inner-page-heading">{{ $item->department }}</h5>
                        <p class="text-justify"> {!! $item->description !!}</p>
                     </div>
                    </div>
                    <div class="col-lg-5">
                       <div class="management-img">
                        <img class=""src="{{ asset($item->image) }}" alt="">
                       </div>
                    </div>
                </div>
                
         
             </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection