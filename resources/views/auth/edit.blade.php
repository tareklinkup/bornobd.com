@extends('layouts.admin')
@section('title', 'Create User')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> > <a href="{{ route('user.index') }}">Add user </a> > Update User</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            User Form
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            
            <form id="customer_form" action="{{ route('user.update', $user) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" id="method_type" value="post">
                <div class="row">
                     <div class="col-md-6">
                         <div class="row">
                            <div class="col-md-4">
                                <label> Name </label>
                            </div>
                            <div class="col-md-1 text-right">
                                 <span class="clone">:</span>
                             </div>
                            <div class="col-md-7">
                                 <input type="text" name="name"  value="{{$user->name}}" class="form-control my-form-control @error('name') is-invalid @enderror "  id="name"> 
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                             </div> 
                             <div class="col-md-4">
                                <label>Email </label>
                            </div>
                            <div class="col-md-1 text-right">
                                 <span class="clone">:</span>
                             </div>
                             <div class="col-md-7">
                                <input type="email" name="email" value="{{$user->email}}" class="form-control my-form-control  @error('email') is-invalid @enderror" >
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                             </div> 
                             <div class="col-md-4">
                                <label>Username </label>
                            </div>
                            <div class="col-md-1 text-right">
                                 <span class="clone">:</span>
                             </div>
                             <div class="col-md-7">
                                <input type="text" name="username" disabled value="{{$user->username}}" autocomplete="off" class="form-control my-form-control  @error('username') is-invalid @enderror" >
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                    @enderror
                            </div> 

                             <div class="col-md-4">
                                <label>Select Role </label>
                            </div>
                            <div class="col-md-1 text-right">
                                 <span class="clone">:</span>
                             </div>
                             <div class="col-md-7">
                                <select class="js-example-basic-multiple form-control my-form-control  @error('role') is-invalid @enderror" data-live-search="true" name="role">
                                    <option  data-tokens="ketchup mustard">Select Role</option>
                                    <option value="1" {{ '1' == $user->role ? 'selected' : '' }}>Super Admin</option>
                                    <option value="2" {{ '2' == $user->role ? 'selected' : '' }} >Admin</option>
                                    <option value="3" {{ '3' == $user->role ? 'selected' : '' }}>User</option>
                                </select>
                                <strong><span class="text-danger" id="areaidError"></span></strong>
                             </div> 
                         </div>
                     </div>
                     <div class="col-md-6">
                        <div class="row right-row">
                             <div class="col-md-4">
                                <label>Image </label>
                            </div>
                            <div class="col-md-1 text-right">
                                 <span class="clone">:</span>
                             </div>
                             <div class="col-md-5">
                                <input type="file" class="form-control my-form-control  @error('image') is-invalid @enderror" id="image" name="image" onchange="readURL(this);">
                                <strong><span class="text-danger" id="imageError"></span></strong>
                            </div>
                            <div class="col-md-2 ps-0">
                                <img class="form-controlo img-thumbnail w-100" src="#" id="previewImage" style="height:80px; background: #3f4a49;">
                            </div>
                            <div class="col-md-12">
                                <button type="submit" id="submit-btn" class="btn btn-primary btn-sm mt-2 float-right submit-btn" value="Submit">Submit</button>
                            </div>
                        </div>
                    </div>  
                </div>
            </form>
        </div>
   </div>
        <div class="row">
            <div class="col-12">
               <div class="card"> 
                <div class="card-header">
                    <div class="table-head"><i class="fas fa-table me-1"></i>User List</div>
                </div>
                <div class="card-body table-card-body p-3">
                    <table id="datatablesSimple">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>User Name</th>
                                <th>Status</th>
                                <th>Role</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="customer_body">
                            @foreach ($userList as $key=> $item)
                            <tr  class="text-center">
                                <td>{{$key+1}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->username}}</td>
                                <td>@if($item->status == '1') Active @else Inactive @endif</td>
                                <td>
                                    @if ($item->role == 1)
                                        Super Admin
                                    @endif
                                    @if($item->role == 2)
                                        Admin
                                    @endif
                                    @if($item->role == 3)
                                    User
                                    @endif
                                </td>
                                <td class="text-center">
                                    <img src="{{ asset($item->image) }}" class="tbl-image" alt="">
                                </td>
                                <td class="text-center">
                                    @if(Auth::user()->role == 1)
                                    <a href="{{route('user.edit',$item->id)}}" class="btn-edit edit-btn"><i class="fas fa-pencil-alt"></i></a>
                                    <button type="submit" class="btn btn-delete" onclick="deleteUser({{ $item->id }})"><i class="far fa-trash-alt"></i></button>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('user.destroy', $item) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endif
                                </td>
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>        
@endsection
@push('admin-js')
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload=function(e) {
                $('#previewImage')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(80);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage").src="{{ asset($item->image) }}";
</script>
    
@endpush
