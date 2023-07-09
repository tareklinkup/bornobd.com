@extends('layouts.admin')
@section('title', 'Video Gallery Update')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Video Gallery Update</span>
    </div>
    <div class="card mb-3">
        
        <div class="card-body table-card-body p-3 mytable-body">
        
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class=""><i class="fas fa-video me-1"></i>Update Video</div>
                            </div>
                            <div class="card-body table-card-body">
                            <form action="{{ route('video.update', $video) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><strong>Video Title</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                    <input type="text" name="title" value="{{ $video->title }}" placeholder="Video Title" class="form-control my-form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                      @enderror 
                                    </div>
                                    <div class="col-md-3">
                                        <label><strong>Video link</strong></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="url" name="youtube_link" value="{{ $video->youtube_link }}" placeholder="Video Title" class="form-control my-form-control @error('youtube_link') is-invalid @enderror">
                                            @error('youtube_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> 
                                            @enderror 
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-sm btn-primary  mt-2" value="Submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>  
                </div>
             </div>
        </div>
    </div>
</main>        
@endsection
