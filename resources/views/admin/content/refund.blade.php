@extends('layouts.admin')
@section('title', 'Refund Policy')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Refund Policy</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            Refund Policy
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            <form action="{{route('refund.update',$company)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>Refund Title</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" value="{{$company->refund_title}}" name="refund_title" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Refund Policy Description</label>
                    </div>
                    <div class="col-md-9">
                        {{-- <div class="form-control" id="editor">
                        </div> --}}
                        <textarea name="refund_details" id="editor" class="form-control">
                            {!! $company->refund_details !!}
                        </textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary mt-2 float-right" value="Submit">Update</button>
                    </div>
                </div>
            </form>
        </div>
   </div>
      
    </div>
</main>        
@endsection
@push('admin-js')
<script src="{{ asset('admin/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>


@endpush