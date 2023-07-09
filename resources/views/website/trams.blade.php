@extends('layouts.website')
@section('title', 'Trams and Condition')
@section('website-content')

    <!-- aboutus-sectio start-->

    <div class="container">
        <nav class="border pt-2 px-3 my-3 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">Trams And Condition</li>
            </ol>
        </nav>
    </div>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12 pt-3">
                    <h3 class="inner-page-heading">{{ $content->trams_condition_title }}</h3>
                    <p class="text-justify"> {!! $content->trams_condition !!}</p>
                </div>
            </div>
        </div>
    </section>
    <!--aboutus-sectio end-->


@endsection
