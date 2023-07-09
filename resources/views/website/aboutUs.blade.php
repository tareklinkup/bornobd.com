@extends('layouts.website')
@section('title', 'About us')
@section('website-content')

    <!-- aboutus-sectio start-->

    <div class="container">
        <nav class="border pt-2 px-3 my-3 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">About us</li>
            </ol>
        </nav>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 pt-3">
                    <img class="float-end p-3" style="max-width: 100%; max-height: 680px"
                        src="{{ asset($content->about_image) }}" alt="">
                    <h3 class="inner-page-heading">{{ $content->about_title }}</h3>

                    <p class="text-justify"> {!! $content->about_description !!}</p>
                </div>
            </div>
        </div>
    </section>
    <!--aboutus-sectio end-->


@endsection
