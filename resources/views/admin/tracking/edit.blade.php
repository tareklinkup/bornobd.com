@extends('layouts.admin')
@section('title', 'Store Location Update')
@section('admin-content')
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Order Tracker Update</span>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-user-plus"></i>
                            Order Tracker Update
                        </div>
                        <div class="card-body table-card-body p-3 mytable-body">
                            <form action="{{ route('tracking.update', $track->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Courier service Name</label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="text" name="name" value="{{  $track->name }}" class="form-control my-form-control @error('name') is-invalid @enderror">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label> Link </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="url" name="link" value="{{  $track->link }}"
                                            class="form-control my-form-control  @error('link') is-invalid @enderror">
                                        @error('link')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label> Details </label>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <span class="clone">:</span>
                                    </div>
                                    <div class="col-md-8">
                                        <textarea name="details"  class="form-control my-form-control  @error('details') is-invalid @enderror" id="" cols="30" rows="2">{{  $track->details }} </textarea>
                                        @error('details')
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