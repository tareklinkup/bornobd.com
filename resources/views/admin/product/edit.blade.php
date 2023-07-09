@extends('layouts.admin')
@section('title', 'Product Edit')
@push('admin-css')
    <style>
        header {
            font-size: 9px;
            color: #f00;
            text-align: center;
        }
    </style>
@endpush
@section('admin-content')
    <main class="mb-5">
        <div class="container">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Edit
                    Product</span>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-1"><span
                                style="font-size: 14px;
                                                font-weight: 600;
                                                color: #0e2c96;">Edit
                                Product</span> </div>
                        <div class="card-body table-card-body my-table">
                            <form action="{{ route('product.update', $product->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong><label>Product Code</label><span class="color-red">*</span>
                                                    <span class="my-label">:</span> </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="product_code"
                                                    value="{{ $product->product_code }}"
                                                    class="form-control my-form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <strong><label>Name</label><span class="color-red">*</span> <span
                                                        class="my-label">:</span> </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="name" value="{{ $product->name }}"
                                                    placeholder="Product Name"
                                                    class="form-control my-form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Model</label><span class="color-red">*</span> <span
                                                        class="my-label">:</span> </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="text" name="model" value="{{ $product->model }}"
                                                    placeholder="Product Model"
                                                    class="form-control my-form-control @error('model') is-invalid @enderror">
                                                @error('model')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <strong><label>Price</label><span class="color-red">*</span> <span
                                                        class="my-label">:</span> </strong>
                                            </div>

                                            <div class="col-md-8">
                                                <input type="text" name="price" value="{{ $product->price }}"
                                                    placeholder="Price"
                                                    class="form-control my-form-control @error('price') is-invalid @enderror">
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <strong><label>Discount</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>

                                            <div class="col-md-8">
                                                <input type="number" name="discount" id="offer"
                                                    value="{{ $product->discount }}" disabled placeholder="0%"
                                                    max="99"
                                                    class="form-control my-form-control @error('discount') is-invalid @enderror">
                                                @error('discount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Tailorig Charge</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>

                                            <div class="col-md-8">
                                                <input type="number" name="tailoring_charge" id="is_tailoring"
                                                    value="{{ $product->tailoring_charge }}" disabled
                                                    placeholder="Tailoring Charge"
                                                    class="form-control my-form-control @error('tailoring_charge') is-invalid @enderror">
                                                @error('tailoring_charge')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-md-4">
                                                <strong><label>Deal Start</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>

                                            <div class="col-md-8">
                                                <input type="date" name="deal_start" id="deal_start"
                                                    value="{{ old('deal_start') }}" disabled
                                                    class="form-control my-form-control @error('discount') is-invalid @enderror">
                                                @error('deal_start')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Deal End</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>

                                            <div class="col-md-8">
                                                <input type="date" name="deal_end" id="deal_end"
                                                    value="{{ old('deal_end') }}" disabled
                                                    class="form-control my-form-control @error('discount') is-invalid @enderror">
                                                @error('deal_end')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}

                                            <div class="col-md-4">
                                                <strong><label>Short Description</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea name="short_details" class="form-control short_description @error('short_details') is-invalid @enderror"
                                                    id="editor" cols="30" rows="3">{{ $product->short_details }}</textarea>
                                                @error('short_details')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Image</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-5 mt-1">
                                                <input name="image" type="file"
                                                    class="form-control form-control-sm @error('image') is-invalid @enderror"
                                                    id="image" type="file" onchange="readURL(this);">
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <img class="form-controlo img-thumbnail" src="#" id="previewImage"
                                                    style="width: 100px;height: 80px; background: #3f4a49;">
                                            </div>

                                            <div class="col-md-4">
                                                <strong><label>Size Guide</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-5 mt-1">
                                                <input name="sizeguide" type="file"
                                                    class="form-control form-control-sm @error('sizeguide') is-invalid @enderror"
                                                    id="sizeguide" type="file" onchange="readURL2(this);">
                                                @error('sizeguide')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mt-1">
                                                <img class="form-controlo img-thumbnail" src="#"
                                                    id="previewImage3"
                                                    style="width: 100px;height: 80px; background: #3f4a49;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 mt-2">
                                                <strong><label>Similar Product</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            @php
                                                $values = explode(',', $product->simillar_porduct);
                                            @endphp
                                            <div class="col-md-8 mt-2 mb-3">
                                                <select class="js-example-basic-multiple form-control my-form-control mb-3"
                                                    name="simillar_porduct[]" multiple="multiple">
                                                    <option disabled>Select Product</option>
                                                    @foreach ($product_list as $key => $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ in_array($item->id, $values) ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <strong><label>Similar Discount</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>

                                            <div class="col-md-8 mt-2 mb-3">
                                                <input type="number" name="similar_discount" max="99"
                                                    value="{{ $product->similar_discount }}"
                                                    class="form-control my-form-control @error('similar_discount') is-invalid @enderror">
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Category</label><span class="color-red">*</span> <span
                                                        class="my-label">:</span> </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group input-group-sm">
                                                    <select name="category_id" id="category_id"
                                                        class="custom-select js-example-basic-multiple form-control my-select my-form-control @error('category_id') is-invalid @enderror"
                                                        data-live-search="true">
                                                        <option value="">Select Category</option>
                                                        @foreach ($category as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $product->category_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('category.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('category_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="col-md-4">
                                                <strong><label>Sub Category</label><span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <div class="input-group input-group-sm">
                                                    <select name="sub_category_id" id="sub_category_id"
                                                        class="js-example-basic-multiple form-control my-form-control @error('sub_category_id') is-invalid @enderror "
                                                        data-live-search="true">
                                                        <option data-tokens="ketchup mustard" value="">Select Sub
                                                            Category
                                                        </option>
                                                        @if (isset($product->SubCategory->id))
                                                            @foreach ($subCategory as $item)
                                                                <option value="{{ $product->SubCategory->id }}"
                                                                    {{ $product->SubCategory->id == $product->sub_category_id ? 'selected' : '' }}>
                                                                    {{ $product->SubCategory->name }}
                                                                </option>
                                                            @endforeach

                                                        @endif
                                                    </select>
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('subcategory.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('sub_category_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Sub Subcategory</label><span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <div class="input-group input-group-sm">
                                                    <select name="subsubcategory_id" id="subsubcategory_id"
                                                        class="js-example-basic-multiple form-control my-form-control @error('subsubcategory_id') is-invalid @enderror "
                                                        data-live-search="true">
                                                        <option data-tokens="ketchup mustard" value="">Select Sub
                                                            Subcategory
                                                        </option>

                                                        @foreach ($SubsubCategory as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $product->subsubcategory_id ? 'selected' : old('subsubcategory_id') }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('subsubcategory.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('subsubcategory_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Another Category</label><span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <div class="input-group input-group-sm">
                                                    <select name="another_category_id" id="another_category_id"
                                                        class="js-example-basic-multiple form-control my-form-control @error('another_category_id') is-invalid @enderror "
                                                        data-live-search="true">
                                                        <option data-tokens="ketchup mustard" value="">--Another Category--
                                                        </option>

                                                        @foreach ($anotherCategory as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $product->another_category_id ? 'selected' : old('another_category_id') }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('anotherCategory.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('subsubcategory_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Brand</label><span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <div class="input-group input-group-sm">
                                                    <select name="brand_id" id="brand_id"
                                                        class="js-example-basic-multiple form-control my-form-control @error('sub_category_id') is-invalid @enderror "
                                                        data-live-search="true">
                                                        <option value="">Select brand</option>
                                                        @foreach ($brand as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $product->brand_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}</option>
                                                        @endforeach
                                                        </option>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('brand.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('brand_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Size</label><span class="color-red">*</span> <span
                                                        class="my-label">:</span> </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group input-group-sm mt-2">
                                                    @php
                                                        $values = explode(',', $product->size_id);
                                                    @endphp
                                                    @foreach ($size as $item)
                                                        {{-- @foreach ($values as $size) --}}
                                                        <label for="size_{{ $item->id }}">
                                                            {{ $item->name }}</label>
                                                        <input type="checkbox" class="m-1"
                                                            id="size_{{ $item->id }}" name="size_id[]"
                                                            value="{{ $item->id }}"
                                                            {{ in_array($item->id, $values) ? 'checked' : '' }}>
                                                    @endforeach

                                                    {{-- @endforeach --}}
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('size.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('size_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label>Color</label><span class="color-red">*</span> <span
                                                        class="my-label">:</span> </strong>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="input-group input-group-sm mt-2">
                                                    @php
                                                        $colors = explode(',', $product->color_id);
                                                    @endphp
                                                    @foreach ($color as $item)
                                                        <label for="color_{{ $item->id }}">
                                                            {{ $item->name }}</label>
                                                        <input type="checkbox" class="m-1"
                                                            id="color_{{ $item->id }}" name="color_id[]"
                                                            value="{{ $item->id }}"
                                                            {{ in_array($item->id, $colors) ? 'checked' : '' }}>
                                                    @endforeach
                                                    <div class="input-group-append">
                                                        <a class="border rounded my-select my-form-control py-0 px-2"
                                                            href="{{ route('color.index') }}" target="_blank"><i
                                                                class="fas fa-plus"></i></a>
                                                    </div>
                                                </div>
                                                @error('color_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>


                                            <div class="col-md-4">
                                                <strong><label> Product Is</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>

                                            <div class="col-md-8 mt-1">
                                                <input type="checkbox" value="1"
                                                    onclick="toggleEnable('offer','deal_start','deal_end')"
                                                    {{ $product->is_deal == '1' ? 'checked' : '' }} name="is_deal"
                                                    class="" id="">
                                                <label for="">Deal</label>

                                                <input type="checkbox" value="1"
                                                    onclick="toggleEnable2('is_tailoring')"
                                                    {{ $product->is_tailoring == '1' ? 'checked' : '' }}
                                                    name="is_tailoring" class="" id="">
                                                <label for="">Is Tailoring</label>

                                                <input type="checkbox" name="is_feature"
                                                    value="1"
                                                    {{ $product->is_feature == '1' ? 'checked' : '' }} class=""
                                                    id="">
                                                <label for="">Feature</label>


                                                <input type="checkbox" name="new_arrival"
                                                    value="1"
                                                    {{ $product->new_arrival == '1' ? 'checked' : '' }} class=""
                                                    id="">
                                                <label for="">New Arrival</label>

                                                <input type="checkbox" name="is_trending"
                                                    value="1"
                                                    {{ $product->is_trending == '1' ? 'checked' : '' }} class=""
                                                    id="">
                                                <label for="">Trending</label>
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label> Collection Is</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <input id="collection_1" name="is_collection_title_1" type="checkbox"
                                                    value="1"
                                                    {{ $product->is_collection_title_1 == '1' ? 'checked' : '' }}>
                                                <label for="collection_1">{{ $content->is_collection_title_1 }}</label>
                                                <input id="collection_2" name="is_collection_title_2" type="checkbox"
                                                    value="1"
                                                    {{ $product->is_collection_title_2 == '1' ? 'checked' : '' }}>
                                                <label for="collection_2">{{ $content->is_collection_title_2 }}</label>
                                            </div>
                                            <div class="col-md-4">
                                                <strong><label> Description</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <textarea name="description" class="form-control" id="description" cols="30" rows="3"></textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            {{-- <div class="col-md-4 mt-2">
                                                <strong><label>Reward Point</label> <span
                                                        class="my-label">:</span> </strong>
                                            </div>

                                            <div class="col-md-8 mt-2">
                                                <input type="text" name="reward_point" value="{{ $product->reward_point}}"
                                                    placeholder="Enter reward point"
                                                    class="form-control my-form-control @error('reward_point') is-invalid @enderror">
                                                @error('reward_point')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}
                                            <div class="col-md-4">
                                                <strong><label>Other Image</label> <span class="my-label">:</span>
                                                </strong>
                                            </div>
                                            <div class="col-md-8 mt-1">
                                                <input type="file" class=" form-control form-control-sm"
                                                    maxlength="5" id="otherImage" name="otherImage[]" multiple />
                                                @foreach ($otherImage as $item)
                                                    <span class="pip">
                                                        <img src="{{ asset('uploads/products/others/small/' . $item->other_small_image) }}"
                                                            class="imageThumb" data-image_id="{{ $item->id }}"
                                                            alt="">
                                                        <span class="close-btn remove"
                                                            data-image_id="{{ $item->id }}">
                                                            remove
                                                        </span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-sm float-right mt-2">Update</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            {{-- product list --}}

        </div>
        </div>
    </main>

@endsection
@push('admin-js')
    <script src="{{ asset('admin/js/ckeditor.js') }}"></script>
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
    <script>
        function toggleEnable(id, id2, id3) {
            var textbox = document.getElementById(id);
            var start = document.getElementById(id2);
            var end = document.getElementById(id3);
            if (textbox.disabled) {
                document.getElementById(id).disabled = false;
                document.getElementById(id2).disabled = false;
                document.getElementById(id3).disabled = false;
            } else {
                document.getElementById(id).disabled = true;
                document.getElementById(id2).disabled = true;
                document.getElementById(id3).disabled = true;
            }
        }

        function toggleEnable2(id, ) {
            var textbox = document.getElementById(id);

            if (textbox.disabled) {
                document.getElementById(id).disabled = false;
            } else {
                document.getElementById(id).disabled = true;

            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("select[name='category_id']").on('change', function() {
                var category_id = $(this).val();
                $.ajax({
                    url: "{{ url('product/subcategory/list') }}/" + category_id,
                    dataType: "json",
                    method: "GET",
                    success: function(data) {
                        $('#sub_category_id').empty();
                        $.each(data, function(key, value) {
                            $('#sub_category_id').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });

            });
        });

        $(document).ready(function() {
            $("select[name='sub_category_id']").on('change', function() {
                var sub_category_id = $(this).val();
                $.ajax({
                    url: location.origin + "/product/subsubcategory/list/" + sub_category_id,
                    dataType: 'JSON',
                    method: 'GET',
                    beforeSend: () => {
                        $('#subsubcategory_id').html("");
                    },
                    success: function(data) {
                        // console.log(data);
                        $('#subsubcategory_id').empty();
                        $.each(data, function(key, value) {
                            $('#subsubcategory_id').append('<option value="' + value
                                .id +
                                '">' + value.name + '</option>');
                        });
                    }
                });

            });
        });
        $(document).ready(function() {
            $("select[name='subsubcategory_id']").on('change', function() {
                var subsubcategory_id = $(this).val();
                // console.log(subsubcategory_id);
                $.ajax({
                    url: location.origin + "/product/another-category/list/" + subsubcategory_id,
                    dataType: 'JSON',
                    method: 'GET',
                    beforeSend: () => {
                        $('#another_category_id').html("");
                    },
                    success: function(data) {
                        $('#another_category_id').empty();
                        $.each(data, function(key, value) {
                            $('#another_category_id').append('<option value="' + value.id +
                                '">' + value.name + '</option>');
                        });
                    }
                });

            });
        });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
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
        var image = '{{ asset('uploads/products/thumbnail/' . $product->thumb_image) }}'
        document.getElementById("previewImage").src = image;

        function readURL2(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage3')
                        .attr('src', e.target.result)
                        .width(100)
                        .height(80);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        var image = '{{ asset($product->sizeguide) }}'
        document.getElementById("previewImage3").src = image;
    </script>
    <script>
        // multiple image
        $(document).ready(function() {
            if (window.File && window.FileList && window.FileReader) {
                $("#otherImage").on("change", function(e) {
                    var files = e.target.files,
                        filesLength = files.length;
                    for (var i = 0; i < filesLength; i++) {
                        var f = files[i]
                        var fileReader = new FileReader();
                        fileReader.onload = (function(e) {
                            var file = e.target;
                            $("<span class=\"pip\">" +
                                "<img class=\"imageThumb\" src=\"" + e.target.result +
                                "\" title=\"" + file.name + "\"/>" +
                                "<br/><span class=\"remove\">Remove</span>" +
                                "</span>").insertAfter("#otherImage");
                            $(".remove").click(function() {
                                $(this).parent(".pip").remove();
                            });
                        });
                        fileReader.readAsDataURL(f);
                    }
                });
            } else {
                alert("Your browser doesn't support to File API")
            }
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).on('click', '.close-btn', function() {

            var imageId = $(this).data('image_id');
            if (imageId) {
                $.ajax({
                    url: '{{ url('/') }}/product/remove-other-image/' + imageId,
                    method: 'DELETE',
                    success: function(res) {
                        if (res) {
                            $(this).parent().remove();
                        } else {
                            alert('Something went wrong :(');
                        }
                    }.bind(this)
                })
            }
        });
    </script>
@endpush
