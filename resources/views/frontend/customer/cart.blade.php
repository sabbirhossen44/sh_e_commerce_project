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
                                {{-- <li><a href="product.html">Product Page</a></li> --}}
                                <li>Cart</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- cart-area-s2 start -->
        <div class="cart-area-s2 section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @php
                        $cart_count = App\Models\Cart::where('customer_id', Auth::guard('customer')->id())->count();
                        @endphp
                        <div class="single-page-title">
                            <h2>Your Cart</h2>
                            <p>There are {{$cart_count}} products in this list</p>
                        </div>
                    </div>
                </div>
                <div class="cart-wrapper">
                    <div class="row">
                        <div class="col-lg-8 col-12">
                            <form action="{{route('cart.update')}}" method="POST">
                                @csrf
                                <div class="cart-item">
                                    <table class="table-responsive cart-wrap">
                                        <thead>
                                            <tr>
                                                <th class="images images-b">Product</th>
                                                <th class="ptice">Price</th>
                                                <th class="stock">Quantity</th>
                                                <th class="ptice total">Subtotal</th>
                                                <th class="remove remove-b">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                            $subtotal = 0;
                                            @endphp
                                                
                                            @forelse ($carts as $cart)
                                            <tr class="wishlist-item">
                                                <td class="product-item-wish">
                                                    <div class="check-box"><input type="checkbox"
                                                            class="myproject-checkbox">
                                                    </div>
                                                    <div class="images">
                                                        <span>
                                                            <img src="{{asset('uploads/product/preview/'. $cart->rel_to_product->preview)}}" alt="">
                                                        </span>
                                                    </div>
                                                    <div class="product">
                                                        <ul>
                                                            <li class="first-cart">{{Str::substr($cart->rel_to_product->product_name, 0, 20).'..'}}</li>
                                                            <li>
                                                                <div class="rating-product">
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <i class="fi flaticon-star"></i>
                                                                    <span>130</span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="ptice">&#2547;{{$cart->rel_to_product->after_discount}}</td>
                                                <td class="td-quantity">
                                                    <div class="quantity cart-plus-minus">
                                                        <input class="text-value" name="quantity[{{$cart->id}}]" type="text" value="{{$cart->quantity}}">
                                                        <div class="dec qtybutton">-</div>
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                </td>
                                                <td class="ptice">&#2547;{{ $cart->rel_to_product->after_discount * $cart->quantity}}</td>
                                                <td class="action">
                                                    <ul>
                                                        <li class="w-btn"><a data-bs-toggle="tooltip"
                                                                data-bs-html="true" title="" href="{{route('cart.remove', $cart->id)}}"
                                                                data-bs-original-title="Remove from Cart"
                                                                aria-label="Remove from Cart"><i
                                                                    class="fi ti-trash"></i></a></li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @php
                                            $subtotal += $cart->rel_to_product->after_discount * $cart->quantity;
                                            @endphp
                                            @empty
                                            <tr class="wishlist-item">
                                                <td colspan="4" >
                                                    <h4 class="text-center text-danger">Cart Is Empty</h4>
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>

                                    </table>
                                </div>
                                <div class="cart-action">
                                    {{-- <a class="theme-btn-s2" href="#"><i class="fi flaticon-refresh"></i> Update Cart</a> --}}
                                    <button type="submit" class="theme-btn-s2 btn"><i class="fi flaticon-refresh"></i> Update Cart</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 col-12">
                            
                            @if ($message)
                                <div class="alert alert-danger " id="message">{{$message}}</div>
                            @endif
                            @if ($message_sec)
                                <div class="alert alert-success " id="message_sec">{{$message_sec}}</div>
                            @endif
                            <form action="{{route('cart')}}" method="get">
                                <div class="apply-area mb-3">
                                    <input type="text" name="coupon" class="form-control" placeholder="Enter your coupon">
                                     <button class="theme-btn-s2" type="submit">Apply</button>
                                     
                                </div>
                            </form>
                                @php
                                    
                                    $final_discount =0;
                                    if ($type == 1) {
                                        $final_discount = round($subtotal * $amount / 100);
                                    } elseif ($type == 2) {
                                        $final_discount = round($subtotal - $amount);
                                    }else{
                                        $final_discount = 0;
                                    }
                                    $final_total = $subtotal - $final_discount;
                                @endphp
                                @php
                                    session([
                                        'discount' => $final_discount,
                                        'final_total' => $final_total,
                                    ])
                                @endphp
                            <div class="cart-total-wrap">
                                <h3>Cart Totals</h3>
                                <div class="sub-total">
                                    <h4>Subtotal</h4>
                                    <span>&#2547;{{ $subtotal}}</span>
                                </div>
                                <div class="sub-total my-3">
                                    <h4>Discount</h4>
                                    <span>&#2547;{{$final_discount}}</span>
                                </div>
                                <div class="total mb-3">
                                    <h4>Total</h4>
                                    <span>&#2547;{{ $final_total }}</span>
                                </div>
                                <a class="theme-btn-s2" href="{{route('checkout')}}">Proceed To CheckOut</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-prodact">
                    <h2>You May be Interested in…</h2>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/1.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Wireless Headphones</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$120.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/2.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Blue Bag with Lock</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$160.00</span>
                                        <del class="old-price">$190.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/3.png" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Stylish Pink Top</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>150</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$150.00</span>
                                        <del class="old-price">$200.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img src="assets/images/interest-product/4.png" alt="">
                                    <div class="tag sale">Sale</div>
                                </div>
                                <div class="text">
                                    <h2><a href="product-single.html">Brown Com Boots</a></h2>
                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>120</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">$120.00</span>
                                        <del class="old-price">$150.00</del>
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- cart-area end -->
      
    </div>
    <!-- end of page-wrapper -->


@endsection
@section('footer_scrtipt')
    <script>
        setTimeout(() => {
            const message = document.getElementById('message');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000);
    </script>
    <script>
        setTimeout(() => {
            const message = document.getElementById('message_sec');
            if (message) {
                message.style.display = 'none';
            }
        }, 5000);
    </script>
@endsection