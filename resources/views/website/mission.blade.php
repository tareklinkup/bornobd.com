@extends('layouts.website')
@section('title', 'Mission And Vission')
@section('website-content')

    <!-- aboutus-sectio start-->

    <div class="container">
        <nav class="border pt-2 px-3 my-3 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">Mission And Vission</li>
            </ol>
        </nav>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 pt-3">
                    <h3 class="inner-page-heading">{{ $content->mission_vision_title }}</h3>
                    <p class="text-justify"> {!! $content->mission_vision !!}</p>
                </div>
            </div>
        </div>
    </section>
    <!--aboutus-sectio end-->


@endsection
