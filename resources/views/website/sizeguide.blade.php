@extends('layouts.website')
@section('title', 'Size Guide')
@section('website-content')

<div class="container">
    <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
        <ol class="breadcrumb mb-2">
            <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
            <li class="breadcrumb-item active fw-bolder" aria-current="page">Size Guide</li>
        </ol>
    </nav>
</div>
<section>
    <div class="container">
        <img src="{{ asset($content->size_guide) }}" alt="">
    </div>
</section>

@endsection