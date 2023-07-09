@extends('layouts.website')
@section('title', 'Store list')

@section('website-content')
    <div class="container">
        <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">Store Location</li>
            </ol>
        </nav>
    </div>
    <section class="pt-4">
        <div class="container mb-3">
            <div class="row">
                @foreach ($store as $item)
                    <div class="col-6">
                        <div class="card shadow mb-3 p-3 rounded-0">
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{ asset('rang-brand-logo.png') }}" class="w-100" alt="">
                                </div>
                                <div class="col-9">
                                    <h4 class="store-title">{{ $item->name }}</h4>
                                    <p class="store-tex mb-0">{!! $item->address !!}</p>
                                    <a class="mb-0 store-tex" href="tel://{{ $item->phone }}">{{ $item->phone }}</a>
                                    <p class="mb-0 store-tex"><span class="store-title">Weekly Closed Day</span>
                                        :{{ $item->close_day }}</p>
                                    <p class="mb-0 store-tex"><span class="store-title">Find Location:</span> <a href="{{ $item->location }}" target="_blank">{{ $item->location }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
