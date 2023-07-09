@extends('layouts.admin')
@section('title', 'Question Reply')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Question Reply</span>
    </div>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fas fa-cogs"></i>
            Question Reply
        </div>
        <div class="card-body table-card-body p-3 mytable-body">
            <form action="{{ route('answar.store', $question->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                            <p>{{$question->question}}</p>
                            <div class="form-group">
                                <input type="hidden" name="product_id" value="{{$question->product_id}}">
                                <input type="hidden" name="question_id" value="{{$question->id}}">
                                <label for="">Answare: </label>
                                <textarea name="answar" class="form-control" rows="4"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Reply</button>
                    </div>
                </div>
                        
                  
                </div>
            </form>
        </div>
   </div>
      
    </div>
</main>        
@endsection
@push('admin-js')


@endpush