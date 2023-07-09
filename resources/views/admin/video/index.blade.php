@extends('layouts.admin')
@section('title', 'Video Gallery')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Video Gallery</span>
    </div>
    <div class="card mb-3">
        
        <div class="card-body table-card-body p-3 mytable-body">
        
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class=""><i class="fas fa-video me-1"></i>Add Video</div>
                            </div>
                            <div class="card-body table-card-body">
                            <form action="{{ route('video.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong><label>Video Title</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                    <input type="text" name="title" placeholder="Video Title" class="form-control my-form-control @error('title') is-invalid @enderror">
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span> 
                                      @enderror 
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Video link</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="url" name="youtube_link" placeholder="Video Title" class="form-control my-form-control @error('youtube_link') is-invalid @enderror">
                                            @error('youtube_link')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span> 
                                            @enderror 
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-sm btn-primary float-right mt-2" value="Submit">Create</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card"> 
                                 <div class="card-header">
                                     <div class="table-head"><i class="fas fa-table me-1"></i>Video List</div>
                                 </div>
                                 <div class="card-body table-card-body p-3">
                                     <table id="datatablesSimple">
                                         <thead class="text-center bg-light">
                                             <tr>
                                                 <th>SL</th>
                                                 <th>Video Title</th>
                                                 <th>Video Link</th>
                                                 <th>Action</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @foreach ($video as $key=> $item)
                                            <tr>
                                                <td>{{ $key +1 }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td><iframe width="42" height="31" src="{{ asset($item->youtube_link) }}"></iframe></td>
                                                <td class="text-center">
                                                    <a href="{{ route('video.edit', $item->id) }}" class="btn btn-edit"><i class="fas fa-pencil-alt"></i></a>
                                                    <button type="submit" class="btn btn-delete" onclick="deleteUser({{ $item->id }})"><i class="far fa-trash-alt"></i></button>
                                                        <form id="delete-form-{{ $item->id }}" action="{{ route('video.destroy', $item) }}"
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
