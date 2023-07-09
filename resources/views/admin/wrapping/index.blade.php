@extends('layouts.admin')
@section('title', 'DataTable')
@section('admin-content')
    <main>
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class=""
                        href="{{ route('admin.index') }}">Home</a> >Wrapper</span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class=""><i class="fab fa-servicestack me-1"></i>Add Wrapper</div>
                        </div>
                        <div class="card-body table-card-body">
                            <form id="Service" action="{{ route('wrapping.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong><label>Name</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" id="name"
                                            class="form-control my-form-control @error('name') is-invalid @enderror"
                                            name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Price</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" id="price"
                                            class="form-control my-form-control @error('price') is-invalid @enderror"
                                            name="price">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-3">
                                        <strong><label>Details</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-9 mt-2">
                                        <textarea class="form-control  @error('details') is-invalid @enderror" name="details"></textarea>
                                        @error('details')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <strong><label>Image</label> <span class="float-right">:</span></strong>
                                    </div>
                                    <div class="col-md-5 mt-2">
                                        <input type="file" class="form-control my-form-control" id="image" name="image"
                                            onchange="readURL(this);">

                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <img class="form-controlo img-thumbnail" src="#" id="previewImage"
                                            style="height:100px;width:120px; background: #3f4a49;">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-sm mt-2 float-right mt-3"
                                            value="Submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="table-head"><i class="fas fa-table me-1"></i>Wrapper List <a href=""
                                    class="float-right"><i class="fas fa-print"></i></a></div>
                        </div>
                        <div class="card-body table-card-body p-3">
                            <table id="datatablesSimple">
                                <thead class="text-center bg-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>price</th>
                                        <th>image</th>
                                        <th width="20%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($wrapper as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td class="text-right">{{$item->price}}Tk</td>
                                            <td class="text-center"><img src="{{ asset($item->image) }}" alt=""
                                                    height="20" width="20"></td>
                                            <td class="text-center">

                                                <form action="{{ route('wrapping.delete', $item->id) }}" method="post">
                                                    <a href="{{ route('wrapping.edit', $item->id) }}"
                                                        class="btn btn-edit btn-sm"><i class="fas fa-edit"></i></a>
                                                    @csrf
                                                    <button type="submit" class="btn btn-delete"><i
                                                            class="fas fa-trash"></i></button>
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
    @push('admin-js')

        <script src="{{ asset('admin/js/sweetalert2.all.js') }}"></script>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImage')
                            .attr('src', e.target.result)
                            .width(100)
                            .height(80);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            document.getElementById("previewImage").src = "/noimage.png";

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
