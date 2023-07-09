@extends('layouts.website')
@section('title', 'About us')
@section('website-content')

    <!-- aboutus-sectio start-->

    {{-- <div class="container">
        <nav class="border pt-2 px-3 my-3 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">{{ $partner->name }}</li>
            </ol>
        </nav>
    </div> --}}
    <section>
        <div class="container mt-4">
            <div class="text-center"> 
                <img  src="{{ asset($partner->image) }}" alt="">
                <h3 class="mt-2">{{ $partner->name }}</h3>
            </div>
            <div class="row">
                <div class="col-12 pt-3">
                    <img class="float-end p-3" style="max-width: 100%; max-height: 300px"
                        src="{{ asset($partner->details_image) }}" alt="">
                    <p class="text-justify"> {!! $partner->details !!}</p>
                </div>
            </div>
        </div>
    </section>
    <!--aboutus-sectio end-->


@endsection
