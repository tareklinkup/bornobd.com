@extends('layouts.admin')
@section('title', 'Permission')
@section('admin-content')
<main>
   <div class="container ">
    <div class="heading-title p-2 my-2">
        <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="{{route('admin.index')}}">Home</a> >User Permission</span>
    </div>
    <div class="card"> 
        <div class="card-header">
            <div class="table-head"><i class="fas fa-table me-1"></i>Permission List <a href="" class="float-right"><i class="fas fa-print"></i></a></div>
        </div>
        <form action="{{route('permission.store',$user->id)}}" method="post">
            @csrf
            <div class="row m-3">
                {{-- // select All --}}
                <div class="col-md-12">
                    <div class="text-center">
                        <input type="checkbox" name="select_all" class="form-check-input" id="select-all">
                        <label for=""><strong> Select All</strong></label>
                    </div>
                </div>
                 {{-- select order list --}}
                <div class="col-md-4 mt-2">
                    <div class="ml-4">
                        <input type="checkbox" class="form-check-input" id="select-all-group">
                        <label class="form-check-label" for="flexCheckDefault"><strong>Order List All</strong></label>
                    </div>
                    @foreach ($orders as $page)
                        @if(in_array($page->id, $permissions))
                            <div class="form-check">
                                <input class="form-check-input-1" name="page_id[]" checked   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                {{$page->display_name}}
                                </label>
                            </div> 
                        @else 
                        <div class="form-check">
                            <input class="form-check-input-1" name="page_id[]"   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$page->display_name}}
                            </label>
                        </div> 
                        @endif
                    @endforeach
                </div>
                <div class="col-md-4 mt-2">
                    <div class="ml-4">
                        <input type="checkbox" class="form-check-input" id="select-all-product">
                        <label class="form-check-label" for="flexCheckDefault"><strong>Product</strong></label>
                    </div>
                    @foreach ($products as $key=> $page)
                        @if(in_array($page->id, $permissions))
                            <div class="form-check">
                                <input class="form-check-input-2" name="page_id[]" checked   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                {{$page->display_name}}
                                </label>
                            </div> 
                        @else 
                        <div class="form-check">
                            <input class="form-check-input-2" name="page_id[]"   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$page->display_name}}
                            </label>
                        </div> 
                        @endif
                    @endforeach
                </div>
    
                <div class="col-md-4 mt-2">
                    <div class="ml-4">
                        <input type="checkbox" class="form-check-input" id="select-all-content">
                        <label class="form-check-label" for="flexCheckDefault"><strong>Website Content List All</strong></label>
                    </div>
                    @foreach ($contents as $page)
                            @if(in_array($page->id, $permissions))
                            <div class="form-check">
                                <input class="form-check-input-3" name="page_id[]" checked   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                {{$page->display_name}}
                                </label>
                            </div> 
                            @else 
                            <div class="form-check">
                                <input class="form-check-input-3" name="page_id[]"   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                {{$page->display_name}}
                                </label>
                            </div> 
                            @endif
                    @endforeach
                </div>
    
                <div class="col-md-4 mt-2">
                    <div class="ml-4">
                        <input type="checkbox" class="form-check-input" id="select-all-setting">
                        <label class="form-check-label" for="flexCheckDefault"><strong>Setting List All</strong></label>
                    </div>
                    @foreach ($settings as $page)
                        @if(in_array($page->id, $permissions))
                        <div class="form-check">
                            <input class="form-check-input-4" name="page_id[]" checked   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$page->display_name}}
                            </label>
                        </div> 
                        @else 
                        <div class="form-check">
                            <input class="form-check-input-4" name="page_id[]"   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$page->display_name}}
                            </label>
                        </div> 
                        @endif
                    @endforeach
                </div>
    
                <div class="col-md-4 mt-2">
                    <div class="ml-4">
                        <input type="checkbox" class="form-check-input" id="select-all-customer">
                        <label class="form-check-label" for="flexCheckDefault"><strong>Customer All</strong></label>
                    </div>
                    @foreach ($customers as $page)
                        @if(in_array($page->id, $permissions))
                        <div class="form-check">
                            <input class="form-check-input-5" name="page_id[]" checked   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$page->display_name}}
                            </label>
                        </div> 
                            @else 
                            <div class="form-check">
                                <input class="form-check-input-5" name="page_id[]"   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                                <label class="form-check-label" for="flexCheckDefault">
                                {{$page->display_name}}
                                </label>
                            </div> 
                            @endif   
                    @endforeach
                </div>
    
                <div class="col-md-4 mt-2">
                    <div class="ml-4">
                        <input type="checkbox" class="form-check-input" id="select-all-others">
                        <label class="form-check-label" for="flexCheckDefault"><strong>Other's All</strong></label>
                    </div>
                    @foreach ($others as $page)
                    @if(in_array($page->id, $permissions))
                    <div class="form-check">
                        <input class="form-check-input-6" name="page_id[]" checked   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                        <label class="form-check-label" for="flexCheckDefault">
                        {{$page->display_name}}
                        </label>
                    </div> 
                        @else 
                        <div class="form-check">
                            <input class="form-check-input-6" name="page_id[]"   type="checkbox" value="{{$page->id}}" id="flexCheckDefault"/>
                            <label class="form-check-label" for="flexCheckDefault">
                            {{$page->display_name}}
                            </label>
                        </div> 
                        @endif 
                    @endforeach
                </div>
                
            </div>
            <button type="submit" class="btn btn-info float-right mb-5 mr-5" value="Save">Save</button>
        </form>
        
   </div>
</main>        
@endsection
@push('admin-js')
<script language="JavaScript">
    // select all
    document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
        }
    }
    </script>
    <script type="text/javascript">

    
        $(document).ready(function () {
            $('#select-all-group').click(function (event) {
                if (this.checked) {
                    $('.form-check-input-1').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.form-check-input-1').each(function () {
                        this.checked = false;
                    });
                }
            });
    
        });
    
    </script>
    
     <script type="text/javascript">
     // product select all
        $(document).ready(function () {
            $('#select-all-product').click(function (event) {
                if (this.checked) {
                    $('.form-check-input-2').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.form-check-input-2').each(function () {
                        this.checked = false;
                    });
                }
            });
    
        });
    
    </script>

<script type="text/javascript">
 // content select all
    $(document).ready(function () {
        $('#select-all-content').click(function (event) {
            if (this.checked) {
                $('.form-check-input-3').each(function () {
                    this.checked = true;
                });
            } else {
                $('.form-check-input-3').each(function () {
                    this.checked = false;
                });
            }
        });

    });

</script>

<script type="text/javascript">
 // setting select all
    $(document).ready(function () {
        $('#select-all-setting').click(function (event) {
            if (this.checked) {
                $('.form-check-input-4').each(function () {
                    this.checked = true;
                });
            } else {
                $('.form-check-input-4').each(function () {
                    this.checked = false;
                });
            }
        });

    });

</script>

<script type="text/javascript">
 // customer select all
    $(document).ready(function () {
        $('#select-all-customer').click(function (event) {
            if (this.checked) {
                $('.form-check-input-5').each(function () {
                    this.checked = true;
                });
            } else {
                $('.form-check-input-5').each(function () {
                    this.checked = false;
                });
            }
        });

    });

</script>

<script type="text/javascript">
 // other select all
    $(document).ready(function () {
        $('#select-all-others').click(function (event) {
            if (this.checked) {
                $('.form-check-input-6').each(function () {
                    this.checked = true;
                });
            } else {
                $('.form-check-input-6').each(function () {
                    this.checked = false;
                });
            }
        });

    });

</script>
@endpush    
