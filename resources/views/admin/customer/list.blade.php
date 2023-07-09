@extends('layouts.admin')
@section('title', 'Customer list')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Customer List</span>
    </div>
   
        <div class="row">
            <div class="col-12">
               <div class="card"> 
                <div class="card-header">
                    <div class="table-head"><i class="fas fa-table me-1"></i>Customer List</div>
                </div>
                <div class="card-body table-card-body p-3">
                    <table id="datatablesSimple">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{-- <th>Customer ID</th> --}}
                                {{-- <th>Username</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $key=> $customer)
                            <tr class="text-center">
                                <td>{{$key+1}}</td>
                                <td>{{$customer->name}}</td>
                                <td>{{$customer->phone}}</td>
                                <td>{{$customer->email}}</td>
                                {{-- <td>{{$customer->code}}</td> --}}
                                {{-- <td>{{$customer->username}}</td> --}}
                                <td>
                                    @if ($customer->status == 'a')
                                    Membership
                                    @else
                                    Genarel
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($customer->status == 'p')
                                    <a href="{{route('customer.active',$customer->id)}}" class="btn btn-sm btn-danger">Inactive</a>
                                    @else
                                    <a href="{{route('customer.deactive',$customer->id)}}" class="btn btn-sm btn-primary">Active</a>
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
@endpush