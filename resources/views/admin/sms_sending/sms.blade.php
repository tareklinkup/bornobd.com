@extends('layouts.admin')
@section('title', 'SMS Sending')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >Sent SMS to Customers</span>
    </div>
    
                <div class="row">
                    <form action="{{route('sent.sms.multiple')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class=""><i class="fas fa-envelope me-1"></i>SMS Sent</div>
                            </div>
                            <div class="card-body table-card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                      <textarea class="form-control" name="sms" rows="7" placeholder="Enter your Message"></textarea>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 float-right" value="Submit">Sent</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   
                    <div class="col-md-12 mt-3">
                        <div class="card"> 
                            <div class="card-header">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Customer List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
                            </div>
                            <div class="card-body table-card-body p-3">
                                {{-- <table id="" class="table text-center table-bordered">
                                    <thead class="text-center thead-dark">
                                        <tr>
                                            <th width="10%"><input id="selectAll" type="checkbox"> <label for='selectAll'> Select All</label></th>
                                            <th>Customer ID</th>
                                            <th>Customer Name</th>
                                            <th>Mobile No.</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                        <tr>
                                            <td><input class="form-check-input-2" name="customer_id[]"   type="checkbox" value="{{(int)$customer->id}}" id="flexCheckDefault"/></td>
                                            <td>{{$customer->code}}</td>
                                            <td>{{$customer->name}}</td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->address}}</td>
                                            <td><a href="{{route('customer.deactive',$customer->id)}}" class="btn btn-sm btn-primary">Active</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table> --}}
                                <input id="selectAll" class="text-center" type="checkbox"> <label for='selectAll'> Select All</label>
                                <br/>
                                <br/>
                                <table id="first_table" class="text-center">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th width="10%">SL</th>
                                            <th>Customer ID</th>
                                            <th>Customer Name</th>
                                            <th>Mobile No.</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                        <tr>
                                            <td><input class="form-check-input-2" name="customer_id[]"   type="checkbox" value="{{(int)$customer->id}}" id="flexCheckDefault"/></td>
                                            <td>{{$customer->code}}</td>
                                            <td>{{$customer->name}}</td>
                                            <td>{{$customer->phone}}</td>
                                            <td>{{$customer->address}}</td>
                                            <td><a href="{{route('customer.deactive',$customer->id)}}" class="btn btn-sm btn-primary">Active</a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
           
    </div>
</main>        
@endsection
@push('admin-js')
<script src="{{ asset('admin/js/ckeditor.js') }}"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#short_details' ) )
        .catch( error => {
            console.error( error );
        } );
        
</script>
<script>
    ClassicEditor
        .create( document.querySelector( '#details' ) )
        .catch( error => {
            console.error( error );
        } );
        
</script>
<script> 
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload=function(e) {
                $('#previewImage')
                    .attr('src', e.target.result)
                    .width(100);
                   
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    document.getElementById("previewImage").src="/noimage.png";
    
</script> 
<script> 
    $("#selectAll").click(function() {
  $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#selectAll").prop("checked", false);
  }
});

jackHarnerSig();
</script> 

@endpush