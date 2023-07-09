@extends('layouts.admin')
@section('title', 'DataTable')
@section('admin-content')
@push('admin-css')
<style>
    .dataTable-table th a {
    text-decoration: none;
    color: inherit;
    text-align: left;
}
.dataTable-table th a:nth-last-child() {
    text-decoration: none;
    color: inherit;
    text-align: center;
}
</style>
@endpush
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Area</span>
    </div>
    <form action="#" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card"> 
                            <div class="card-header">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Area List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                            </div>
                            <div class="card-body table-card-body p-3">
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="home-tab">
                                       <table id="first_table">
                                        <thead class=" bg-light">
                                            <tr>
                                                <th width="10%">SL</th>
                                                <th>Email</th>
                                                <th width="10%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subscriber as $key=> $item)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td class="text-center">
                                                    <a href="" class="btn btn-delete"><i class="fa fa-trash"></i></a>
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
            </form> 
    </div>
</main>        
@endsection
@push('admin-js')
@endpush