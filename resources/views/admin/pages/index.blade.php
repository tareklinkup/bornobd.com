@extends('layouts.admin')
@section('title', 'Page Active')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Area</span>
    </div>
          <div class="row">
              <div class="col-md-12">
                  <div class="card"> 
                      <div class="card-header">
                          <div class="table-head"><i class="fas fa-table me-1"></i>Page List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                      </div>
                      <div class="card-body table-card-body p-3">
                          <table id="datatablesSimple"  class="text-center table-striped" width="100%">
                              <thead class="bg-light">
                                  <tr class="">
                                      <th width="10%">SL</th>
                                      <th width="70%">Name</th>
                                      <th width="20%" class="text-center">Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach ($pages as $key=> $page)
                                  <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$page->display_name}}</td>
                                    <td class="text-center text-nowrap">
                                      <form action="{{route('page.active')}}" class="" method="post">
                                          @csrf
                                          <input type="hidden" name="id" value="{{$page->id}}">
                                          @if ($page->status == 1)
                                              <button type="submit" class="btn btn-edit">Active</button>
                                              @else
                                              <button type="submit" class="btn btn-delete">Deactive</button>
                                          @endif
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
@endpush