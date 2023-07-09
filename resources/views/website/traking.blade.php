@extends('layouts.website')
@section('title', 'Store list')

@section('website-content')
    <div class="container">
        <nav class="border pt-2 px-3 my-2 bg-light" style="" aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item fw-bold"><a href="{{ route('home.index') }}">Home</a></li>
                <li class="breadcrumb-item active fw-bolder" aria-current="page">Tracking</li>
            </ol>
        </nav>
    </div>
    <section class="pt-4">
        <div class="container mb-3">
            <div class="row">
                @foreach ($track as $item)
                    <div class="col-6">
                        <div class="card shadow mb-3 p-3 rounded-0">
                            <div class="row">
                               
                                <div class="col-12">
                                    <h2 class="track-title text-center">{{ $item->name }}</h2>
                                 
                                    <p class="mb-0 store-tex" style="text-align: justify">{{ Str::limit($item->details, 250) }}</p>
                                    <div class="d-grid gap-2 mt-3 col-10 mx-auto">
                                        <a class="btn btn-primary"  href="{{ $item->link }}" target="_blank">Track Your Order</a>
                                        
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
