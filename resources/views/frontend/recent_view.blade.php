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
                            <li>Recently Viewed</li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->

    <!-- start of themart-interestproduct-section -->
    <section class="themart-interestproduct-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="wpo-section-title">
                        <h2>Recently Viewed Product</h2>
                    </div>
                </div>
            </div>
            <div class="product-wrap">
                <div class="row">
                    @forelse ($recents as $recent)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="{{asset('uploads/product/preview/' . $recent->preview)}}" alt="">
                                    @if ($recent->discount == null || $recent->discount == 0)
                                        <div class="tag new">New</div>
                                    @else
                                        <div class="tag sale">-{{$recent->discount}}%</div>
                                    @endif

                                </div>
                                <div class="text">
                                    @if (strlen($recent->product_name) > 25)
                                        <h2><a href="{{route('product.details', $recent->slug)}}" title="{{$recent->product_name}}">
                                                {{substr($recent->product_name, 0, 25) . '..'}}
                                            </a></h2>
                                    @else
                                        <h2><a href="{{route('product.details', $recent->slug)}}">{{$recent->product_name}}</a></h2>
                                    @endif

                                    <div class="rating-product">
                                        @php
                                            $total_review = App\Models\OrderProduct::where('product_id', $recent->id)->whereNotNull('review')->count();
                                            $total_stars = App\Models\OrderProduct::where('product_id', $recent->id)->whereNotNull('review')->sum('star');
                                            $avg = 0;
                                            if ($total_review == 0) {
                                                $avg = 0;
                                            } else {
                                                $avg = round($total_stars / $total_review);
                                            }

                                        @endphp
                                        @for ($i = 1; $i <= $avg; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                        @for ($i = $avg; $i <= 4; $i++)
                                            <i class="fa fa-star-o"></i>
                                        @endfor
                                        <span>{{$total_review}}</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">&#2547;{{$recent->after_discount}}</span>
                                        <del class="old-price">
                                            @if ($recent->discount != null || $recent->discount != 0)
                                                &#2547;{{$recent->price}}
                                            @endif
                                        </del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="{{route('product.details', $recent->slug)}}">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3 class="text-center text-danger">You did not view any product.</h3>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- end of themart-interestproduct-section -->
@endsection