@extends('layouts.admin')
@section('title', 'Store Location Update')
@section('admin-content')
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >store Update</span>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-user-plus"></i>
                            Store Location Edit form
                        </div>
                        <div class="card-body table-card-body p-3 mytable-body">
                            <form action="{{ route('store.update', $store->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label> Name </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name"
                                            class="form-control my-form-control @error('name') is-invalid @enderror" value="{{ $store->name }}">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label> Phone </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="phone" value="{{ $store->phone }}"
                                            class="form-control my-form-control  @error('phone') is-invalid @enderror">
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label> Address </label>
                                    </div>

                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="address" class="form-control my-form-control  @error('address') is-invalid @enderror">{{ $store->address }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <label> Close day </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="close_day" value="{{ $store->close_day }}"
                                            class="form-control my-form-control  @error('close_day') is-invalid @enderror">
                                        @error('close_day')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label> Open Hour </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="open_hour" value="{{ $store->open_hour }}"
                                            class="form-control my-form-control  @error('open_hour') is-invalid @enderror">
                                        @error('open_hour')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label> Location </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="location" value="{{ $store->location }}"
                                            class="form-control my-form-control  @error('location') is-invalid @enderror">
                                        @error('location')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary float-right btn-sm">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection