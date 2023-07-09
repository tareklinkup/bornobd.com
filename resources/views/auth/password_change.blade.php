@extends('layouts.admin')
@section('title', 'Create User')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> > <a href="{{ route('user.index') }}"> user </a> > Update Password</span>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card m-b-20">
                <div class="card-body">
                    <form action="{{ route('password.update') }}" method="post">
                        @csrf
                        <div class="col-12 mx-auto mb-3">
                            <label for="current-pwd" class="required">Current Password</label>
                            <input type="password" class="form-control @error('currentPass') is-invalid @enderror" name="currentPass" id="current-pwd" placeholder="Current Password" />
                            @error('currentPass')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}      
                                </span>  
                            @enderror
                        </div>
                      
                            <div class="col-lg-12 mb-3">
                                <label for="new-pwd" class="required">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="new-pwd" placeholder="New Password" />
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}      
                                </span>  
                                @enderror
                            </div>
                            <div class="col-lg-12 mb-3">
                                <div class="single-input-item">
                                    <label for="confirm-pwd" class="required">Confirm Password</label>
                                    <input type="password"  class="form-control @error('password') is-invalid @enderror" name="password_confirmation" id="confirm-pwd" placeholder="Confirm Password" />
                                </div>
                            </div>
                      
                        <div class="single-input-item col-lg-12">
                            <button class="btn btn-danger btn-sm" type="submit">Change Password</button>
                        </div> 
                    </form>
                    
                </div>
            </div>
         </div> <!-- end col -->
            
        </div>
    </div>
    
</main>        
@endsection
@push('admin-js')

    
@endpush
