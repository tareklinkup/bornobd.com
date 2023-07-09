@extends('layouts.admin')
@section('title', 'DataTable')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Area</span>
    </div>
    <div class="card-body table-card-body p-3 mytable-body">
        <form action="{{route('page.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <strong><label>Page Name</label> <span class="my-label">:</span> </strong>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <strong><label>Page Url</label> <span class="my-label">:</span> </strong>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="url" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary mt-2 float-right" value="Submit">Create</button>
                        </div>
                    </div>
                </div>
               
            </div>
        </form>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card"> 
                            <div class="card-header">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Page List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                            </div>
                            <div class="card-body table-card-body p-3">
                                <table id="datatablesSimple" class="text-center">
                                    <thead class="bg-light">
                                        <tr class="">
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Url</th>
                                            <th width="20%" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pages as $key=> $page)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$page->name}}</td>
                                            <td>{{$page->url}}</td>
                                            <td class="text-center text-nowrap">
                                            <input type="hidden" name="id" value="{{$page->id}}">
                                                  <label class="radio-inline">
                                                    <input type="radio" name="optradio" checked>Active
                                                  </label>
                                                  <label class="radio-inline">
                                                    <input type="radio" name="optradio">Deactive
                                                  </label>
                                              
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-12">
                                     <button type="submit" class="btn btn-primary btn-sm float-right mt-2">Save</button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
               
            </form> 
    </div>
</main>        
@endsection
@push('admin-js')
@endpush