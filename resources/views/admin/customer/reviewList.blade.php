@extends('layouts.admin')
@section('title', 'Customer list')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> > Product Review List</span>
    </div>
   
        <div class="row">
            <div class="col-12">
               <div class="card"> 
                <div class="card-header">
                    <div class="table-head"><i class="fas fa-table me-1"></i>Product Review List</div>
                </div>
                <div class="card-body table-card-body p-3">
                    <table id="datatablesSimple">
                        <thead class="text-center bg-light">
                            <tr>
                                <th>SL</th>
                                <th>Product id</th>
                                <th>Name</th>
                                <th>Email</th>
                                {{-- <th>Customer ID</th> --}}
                                <th>Review</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviewList as $key=> $item)
                            <tr class="text-center">
                                <td>{{$key+1}}</td>
                                
                             
                                @if (isset($item->product))
                                <td>{{$item->product->name}}</td>
                                @else
                                <td class="bg-danger text-white">Maybe product was deleted</td>
                                @endif
                               
                                <td>{{$item->customer_name}}</td>
                                <td>{{$item->customer_email}}</td>
                                <td>{{$item->review}}</td>
                                <td>
                                    @if ($item->status == 'a')
                                      <a href="{{ route('review.commnetPending', $item->id)  }}" class="btn btn-primary btn-sm">Active</a>
                                      @else
                                      <a href="{{ route('review.commnetActive', $item->id)  }}" class="btn btn-danger btn-sm">Pending</a>
                                      
                                    @endif
                                </td>
                                {{-- <td>{{$item->phone}}</td> --}}
                               
                                <td class="text-center">
                                    <button type="submit" class="btn btn-delete" onclick="deleteUser({{ $item->id }})"><i class="far fa-trash-alt"></i></button>
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('review.delete', $item->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
<script src="{{ asset('admin/js/sweetalert2.all.js') }}"></script>
<script>
    function deleteUser(id) {
            swal({
                title: 'Are you sure?',
                text: "You want to Delete this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-' + id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }

</script>
@endpush