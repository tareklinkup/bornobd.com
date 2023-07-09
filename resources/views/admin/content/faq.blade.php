@extends('layouts.admin')
@section('title', 'FAQ Page')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >FAQ Page</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-user-plus"></i>
            FAQ Page
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            <form action="{{route('faq.update',$company)}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label>FAQ Title</label>
                    </div>
                    <div class="col-md-9">
                        <input type="text" name="faq_title" value="{{$company->faq_title}}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>FAQ Description</label>
                    </div>
                    <div class="col-md-9">
                        {{-- <div class="form-control" id="editor">
                        </div> --}}
                        <textarea name="faq_details" id="editor" class="form-control">
                            {!! $company->faq_details !!}
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