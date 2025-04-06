@extends('layouts.admin')
@section('style_content')
    <style>
        .upload__box {
            /* padding: 40px; */
        }

        .upload__inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .upload__btn {
            display: block;
            font-weight: 600;
            text-align: left;
            min-width: 116px;
            padding: 7px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid;
            background-color: transparent;
            border-color: #f2f2f2;
            line-height: 26px;
            font-size: 14px;
            color: #000000c9;
        }

        .upload__btn:hover {
            background-color: unset;
            color: #4045ba;
            transition: all 0.3s ease;
        }

        .upload__btn-box {
            margin-bottom: 10px;
        }

        .upload__img-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .upload__img-box {
            width: 200px;
            padding: 0 10px;
            margin-bottom: 12px;
        }

        .upload__img-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 28px;
            z-index: 1;
            cursor: pointer;
        }

        .upload__img-close::after {
            content: "✖";
            font-size: 14px;
            color: white;
        }

        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Edit Product</h3>
                    <a href="{{route('product.list')}}" class="btn btn-primary"><i data-feather="list"></i> Product List</a>
                </div>
                <div class="card-body">
                    @if (session('prodect_update'))
                        <div class="alert alert-success">{{session('prodect_update')}}</div>
                    @endif
                    <form action="{{route('product.update', $product->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label"> Category</label>
                                    <select name="category_id" class="fomr-control category" id="">
                                        <option value="{{$categoriesid->id}}">{{$categoriesid->category_name}}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Sub-Category</label>
                                    <select name="sub_category_id" class="fomr-control subcategory" id="">
                                        <option value="{{$sub_categoriesid->id}}">{{$sub_categoriesid->sub_category}}
                                        </option>
                                        @foreach ($sub_categories as $sub_category)
                                            <option value="{{$sub_category->id}}">{{$sub_category->sub_category}}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_category_id')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Brand</label>
                                    <select name="brand" class="fomr-control" id="">
                                        <option value="{{$brandsid->id}}">{{$brandsid->brand_name}}</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->brand_name}}</option>

                                        @endforeach
                                    </select>
                                    @error('brand')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Product Name</label>
                                    <input type="text" name="product_name" class="form-control" id=""
                                        value="{{$product->product_name}}">
                                    @error('product_name')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Product Price</label>
                                    <input type="number" name="product_price" class="form-control" id=""
                                        value="{{$product->price}}">
                                    @error('product_price')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Discout(%)</label>
                                    <input type="number" name="discount" class="form-control" id=""
                                        value="{{$product->discount}}">
                                    @error('discount')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Tags</label>
                                    <input type="text" name="tags[]" class="form-control border-0 p-0" id="input-tags"
                                        value="{{$product->tags}}">
                                    @error('tags')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Short Description</label>
                                    <input type="text" name="short_desp" class="form-control" id=""
                                        value="{{$product->short_desp}}">
                                    @error('short_desp')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Long Description</label>
                                    <textarea name="long_desp" class="form-control summernote" id="" cols="30"
                                        rows="10">{!! $product->long_desp!!}</textarea>
                                    @error('long_desp')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Additional Information</label>
                                    <textarea name="addi_info" class="form-control summernote" id="" cols="30"
                                        rows="10">{!! $product->addi_info!!}</textarea>
                                    @error('addi_info')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="text" class="form-label">Preview Image</label>
                                    <input type="file" name="preview" class="form-control" id=""
                                        onchange="document.getElementById('blah').src= window.URL.createObjectURL(this.files[0])">
                                    @if ($product->preview)
                                        <img src="{{asset('uploads/product/preview/' . $product->preview)}}" height="100"
                                            width="100" class="mt-2" alt="">
                                    @endif
                                    @error('preview')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                    <div class="my-2">
                                        <img src="" alt="" width="100" id="blah">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">

                                <div class="mb-3">
                                    <div class="upload__box">
                                        <div class="upload__btn-box">
                                            <label for="text" class="form-label">Gallery Image</label> <br>
                                            <label class="upload__btn">
                                                <p>Chose File</p>
                                                <input type="file" multiple="" data-max_length="20" name="gallery[]"
                                                    class="upload__inputfile form-control">
                                                @error('gallery')
                                                    <strong class="text-danger">{{$message}}</strong>
                                                @enderror
                                            </label>

                                        </div>
                                        {{-- <div class="upload__img-wrap"></div>
                                        @foreach ($product_gallery as $image)
                                        <img src="{{asset('uploads/product/gallery/' . $image->gallery)}}" height="150"
                                            width="150" class="mt-2" alt="">

                                        @endforeach --}}
                                        <div class="upload__img-wrap">
                                            @foreach ($product_gallery as $image)
                                                <div class="img-box" id="img-box-{{ $image->id }}"
                                                    style="position: relative; display: inline-block;  margin: 10px;">
                                                    <img src="{{ asset('uploads/product/gallery/' . $image->gallery) }}"
                                                        height="150" width="150" class="mt-2" alt="">

                                                    <!-- Delete Button -->
                                                    <button type="button" class="delete-img-btn" data-id="{{ $image->id }}"
                                                        style="position: absolute; top: 15px; right: 5px; background-color: red; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; font-weight: bold;">
                                                        ×
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('footer_script')
    <script>
        $("#input-tags").selectize({
            delimiter: ",",
            persist: false,
            create: function (input) {
                return {
                    value: input,
                    text: input,
                };
            },
        });
    </script>
    <script>
        $('.category').change(function () {
            var category_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getsubcategory',
                data: { 'category_id': category_id },
                success: function (data) {
                    $('.subcategory').html(data);
                }
            })

        })

    </script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote();
        });
    </script>
    <script>
        jQuery(document).ready(function () {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function () {
                $(this).on('change', function (e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function (f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function (e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>

    <script>
        $(document).ready(function () {
            $('.delete-img-btn').click(function () {
                var imageId = $(this).data('id');
                var confirmed = confirm('Are you sure you want to delete this image?');

                if (confirmed) {
                    $.ajax({
                        url: '/ajax-gallery-image-delete/' + imageId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                $('#img-box-' + imageId).fadeOut(300, function () {
                                    $(this).remove();
                                });
                            }
                        },
                        error: function () {
                            alert('Something went wrong!');
                        }
                    });
                }
            });
        });
    </script>


@endsection