@extends('frontend.master')
@section('content')
    <!-- start wpo-page-title -->
    <section class="wpo-page-title">
        <h2 class="d-none">Hide</h2>
        <div class="container">
            <div class="row">
                <div class="col col-xs-12">
                    <div class="wpo-breadcumb-wrap">
                        <ol class="wpo-breadcumb-wrap">
                            <li><a href="{{route('welcome')}}">Home</a></li>
                            <li>Shop</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- product-area-start -->
    <div class="shop-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="shop-filter-wrap">
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <div class="shop-filter-search">
                                    <form>
                                        <div>
                                            <input type="text" class="form-control" id="search_input2"
                                                placeholder="Search.." value="{{@$_GET['search_input']}}">
                                            <button type="submit" class="search_btn2"><i class="ti-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item category-widget">
                                <div class="filter-item">
                                    <div class="shop-filter-item">
                                        <h2>Categories</h2>
                                        <ul>
                                            @foreach ($categoris as $category)
                                                <li>
                                                    <label class="topcoat-radio-button__label">
                                                        {{$category->category_name}}
                                                        <span>({{App\Models\Product::where('category_id', $category->id)->count()}})</span>
                                                        <input {{$category->id == @$_GET['category_id'] ? 'checked' : ''}}
                                                            class="category" type="radio" name="category_id"
                                                            value="{{$category->id}}">
                                                        <span class="topcoat-radio-button"></span>
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Filter by price</h2>
                                <div class="shopWidgetWraper">
                                    <div class="priceFilterSlider">
                                        <form class="clearfix">
                                            <!-- <div id="sliderRange"></div>
                                                                                    <div class="pfsWrap">
                                                                                        <label>Price:</label>
                                                                                        <span id="amount"></span>
                                                                                    </div> -->
                                            <div class="d-flex">
                                                <div class="col-lg-6 pe-2">
                                                    <label for="" class="form-label">Min</label>
                                                    <input type="text" id="min" class="form-control" placeholder="Min"
                                                        value="{{@$_GET['min']}}">
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="" class="form-label">Max</label>
                                                    <input type="text" id="max" class="form-control" placeholder="Max"
                                                        value="{{@$_GET['max']}}">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-4">
                                                <button type="button"
                                                    class="form-control bg-light price_filter">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Color</h2>
                                <ul>
                                    @foreach ($colors as $color)
                                        <li>
                                            <label class="topcoat-radio-button__label">
                                                {{$color->color_name}}
                                                <span>({{App\Models\Inventory::where('color_id', $color->id)->count()}})</span>
                                                <input {{$color->id == @$_GET['color_id'] ? 'checked' : ''}} class="color"
                                                    type="radio" name="color_id" value="{{$color->id}}">
                                                <span class="topcoat-radio-button"></span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="filter-item">
                            <div class="shop-filter-item">
                                <h2>Size</h2>
                                <ul>
                                    @foreach ($sizes as $size)
                                    <li>
                                        <label class="topcoat-radio-button__label">
                                            {{$size->size_name}} <span>(10)</span>
                                            <input type="radio" name="size_id" value="{{$size->id}}">
                                            <span class="topcoat-radio-button"></span>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div> --}}
                        <div class="filter-item">
                            <div class="shop-filter-item new-product">
                                <h2>New Products</h2>
                                <ul>
                                    @foreach ($new_products as $new_product)
                                        <li>
                                            <div class="product-card">
                                                <div class="card-image">
                                                    <div class="image">
                                                        <img src="{{asset('uploads/product/preview/' . $new_product->preview)}}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    @if (strlen($new_product->product_name) > 15)
                                                        <h3><a href="{{route('product.details', $new_product->slug)}}"
                                                                title="{{$new_product->product_name}}">
                                                                {{substr($new_product->product_name, 0, 15) . '..'}}
                                                            </a></h3>
                                                    @else
                                                        <h3><a
                                                                href="{{route('product.details', $new_product->slug)}}">{{$new_product->product_name}}</a>
                                                        </h3>
                                                    @endif
                                                    @php
                                                        $total_stars = App\Models\OrderProduct::where(
                                                            'product_id',
                                                            $new_product->id
                                                        )->whereNotNull('review')->sum('star');
                                                        $total_review = App\Models\OrderProduct::where(
                                                            'product_id',
                                                            $new_product->id
                                                        )->whereNotNull('review')->count();
                                                        $avg = 0;
                                                        if ($total_review == 0) {
                                                            $avg = 0;
                                                        } else {
                                                            $avg = round($total_stars / $total_review);
                                                        }

                                                    @endphp
                                                    <div class="rating-product">
                                                        @for ($i = 1; $i <= $avg; $i++) <i class="fa fa-star"></i>
                                                        @endfor
                                                        @for ($i = $avg; $i <= 4; $i++) <i class="fa fa-star-o"></i>
                                                        @endfor


                                                        <span>{{$total_review}}</span>
                                                    </div>
                                                    <div class="price">
                                                        <span
                                                            class="present-price">&#2547;{{$new_product->after_discount}}</span>
                                                        <del class="old-price">
                                                            @if ($new_product->discount != null || $new_product->discount != 0)
                                                                &#2547;{{$new_product->price}}
                                                            @else

                                                            @endif
                                                        </del>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="shop-filter-item tag-widget">
                                <h2>Popular Tags</h2>
                                <ul>
                                    @foreach ($tags as $tag)
                                        <li><button class="btn btn-light tag {{$tag->id == @$_GET['tag'] ? 'text-danger' : ''}}"
                                                value="{{$tag->id}}">{{$tag->tag_name}}</button></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="shop-section-top-inner">
                        <div class="shoping-product">
                            <p>We found <span>{{$products->count()}} items</span> for you!</p>
                        </div>
                        <div class="short-by">
                            <ul>
                                <li>
                                    Sort by:
                                </li>
                                <li>
                                    <select name="short" class="sort">
                                        <option value="">Default Sorting</option>
                                        <option {{@$_GET['sort'] == 1 ? 'selected' : ''}} value="1">Price Low To High</option>
                                        <option {{@$_GET['sort'] == 2 ? 'selected' : ''}} value="2">Price High To Low</option>
                                        <option {{@$_GET['sort'] == 3 ? 'selected' : ''}} value="3">Name (A-Z)</option>
                                        <option {{@$_GET['sort'] == 4 ? 'selected' : ''}} value="4">Name (Z-A)</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="product-wrap">
                        <div class="row align-items-center">
                            @forelse ($products as $product)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
                                    <div class="product-item">
                                        <div class="image">
                                            <img src="{{asset('uploads/product/preview/' . $product->preview)}}" alt="">
                                            @if ($product->discount)
                                                <div class="tag sale">-{{$product->discount}}%</div>
                                            @else
                                                <div class="tag new">New</div>
                                            @endif
                                            {{-- <div class="tag new">New</div> --}}
                                        </div>
                                        <div class="text">
                                            @if (strlen($product->product_name) > 20)
                                                <h2><a href="{{route('product.details', $product->slug)}}"
                                                        title="{{$product->product_name}}">
                                                        {{substr($product->product_name, 0, 20) . '..'}}
                                                    </a></h2>
                                            @else
                                                <h2><a
                                                        href="{{route('product.details', $product->slug)}}">{{$product->product_name}}</a>
                                                </h2>
                                            @endif
                                            <div class="rating-product">
                                                @php
                                                    $total_stars = App\Models\OrderProduct::where(
                                                        'product_id',
                                                        $product->id
                                                    )->whereNotNull('review')->sum('star');
                                                    $total_review = App\Models\OrderProduct::where(
                                                        'product_id',
                                                        $product->id
                                                    )->whereNotNull('review')->count();
                                                    $avg = 0;
                                                    if ($total_review == 0) {
                                                        $avg = 0;
                                                    } else {
                                                        $avg = round($total_stars / $total_review);
                                                    }

                                                @endphp
                                                @for ($i = 1; $i <= $avg; $i++) <i class="fa fa-star"></i>
                                                @endfor
                                                @for ($i = $avg; $i <= 4; $i++) <i class="fa fa-star-o"></i>
                                                @endfor
                                                <span>{{$total_review}}</span>
                                            </div>
                                            <div class="price">
                                                <span class="present-price">&#2547;{{$product->after_discount}}</span>
                                                <del class="old-price">
                                                    @if ($product->discount != null || $product->discount != 0)
                                                        &#2547;{{$product->price}}
                                                    @else

                                                    @endif
                                                </del>
                                            </div>
                                            <div class="shop-btn">
                                                <a class="theme-btn-s2" href="{{route('product.details', $product->slug)}}">Shop
                                                    Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <h3 class="text-center text-danger mt-3">No Search Product Found</h3>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- product-area-end -->
@endsection
@section('footer_scrtipt')
    <script>
        $('.category').click(function () {
            var search_input = $('#search_input').val();
            var category_id = $("input[type = 'radio'][name= 'category_id']:checked").val();
            var color_id = $("input[type = 'radio'][name= 'color_id']:checked").val();
            var min = $('#min').val();
            var max = $('#max').val();
            var sort = $('.sort').val();
            var link = "{{route('shop')}}" + "?search_input=" + search_input + "&category_id=" + category_id + '&min=' + min + '&max=' + max + '&color_id=' + color_id + '&sort=' + sort;
            window.location.href = link;
        })

        $('.color').click(function () {
            var search_input = $('#search_input').val();
            var category_id = $("input[type = 'radio'][name= 'category_id']:checked").val();
            var color_id = $("input[type = 'radio'][name= 'color_id']:checked").val();
            var min = $('#min').val();
            var max = $('#max').val();
            var sort = $('.sort').val();
            var link = "{{route('shop')}}" + "?search_input=" + search_input + "&category_id=" + category_id + '&min=' + min + '&max=' + max + '&color_id=' + color_id + '&sort=' + sort;
            window.location.href = link;
        })

        $('.sort').change(function () {
            var search_input = $('#search_input').val();
            var category_id = $("input[type = 'radio'][name= 'category_id']:checked").val();
            var color_id = $("input[type = 'radio'][name= 'color_id']:checked").val();
            var min = $('#min').val();
            var max = $('#max').val();
            var sort = $('.sort').val();
            var link = "{{route('shop')}}" + "?search_input=" + search_input + "&category_id=" + category_id + '&min=' + min + '&max=' + max + '&color_id=' + color_id + '&sort=' + sort;
            window.location.href = link;
        })

        $('.price_filter').click(function () {
            var search_input = $('#search_input').val();
            var category_id = $("input[type = 'radio'][name= 'category_id']:checked").val();
            var color_id = $("input[type = 'radio'][name= 'color_id']:checked").val();
            var min = $('#min').val();
            var max = $('#max').val();
            var sort = $('.sort').val();
            var link = "{{route('shop')}}" + "?search_input=" + search_input + "&category_id=" + category_id + '&min=' + min + '&max=' + max + '&color_id=' + color_id + '&sort=' + sort;
            window.location.href = link;
        })

        $('.search_btn2').click(function (e) {
            e.preventDefault();
            var search_input2 = $('#search_input2').val();
            var link = "{{route('shop')}}" + "?search_input=" + search_input2;
            window.location.href = link;
        })

        $('.tag').click(function (e) {
            e.preventDefault();
            var tag = $(this).val();
            var link = "{{route('shop')}}" + "?tag=" + tag;
            window.location.href = link;
        })
    </script>
@endsection