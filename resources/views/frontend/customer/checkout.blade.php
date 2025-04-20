@extends('frontend.master')
@section('style')
    <style>
        .select2-container--default .select2-selection--single {
            height: 100%;
            margin-top: 9px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444;
            line-height: 28px;
            padding: 5px 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 15px;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <!-- start wpo-page-title -->
        <section class="wpo-page-title">
            <h2 class="d-none">Hide</h2>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="wpo-breadcumb-wrap">
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="{{route('welcome')}}">Home</a></li>
                                <li><a href="{{route('cart')}}">Cart</a></li>
                                <li>Checkout</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- wpo-checkout-area start-->
        <div class="wpo-checkout-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-page-title">
                            <h2>Your Checkout</h2>
                            @php
                                $cart_count = App\Models\Cart::where('customer_id', Auth::guard('customer')->id())->count();
                            @endphp
                            <p>There are {{$cart_count}} products in this list</p>
                        </div>
                    </div>
                </div>
                <form action="{{route('order.store')}}" method="post">
                    @csrf
                    <div class="checkout-wrap">
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="caupon-wrap s3">
                                    <div class="biling-item">
                                        <div class="coupon coupon-3">
                                            <h2>Billing Address</h2>
                                        </div>
                                        <div class="billing-adress">
                                            <div class="contact-form form-style">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="First Name*" id="fname1"
                                                            name="fname" value="{{Auth::guard('customer')->user()->fname}}">
                                                        @error('fname')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Last Name*" id="fname2" name="lname"
                                                            value="{{Auth::guard('customer')->user()->lname}}">
                                                        @error('lname')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <select name="country" id="set_country"
                                                            class="form-control set_country">
                                                            <option value="">Select Country</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('country')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <select id="city" name="city" class="form-control city">
                                                            <option value="">Select Country</option>
                                                        </select>
                                                        @error('city')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="number" placeholder="Postcode / ZIP*" id="Post2"
                                                            name="zip" value="{{Auth::guard('customer')->user()->zip}}">
                                                        @error('zip')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Company Name*" id="Company"
                                                            name="company">
                                                        @error('company')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="email" placeholder="Email Address*" id="email4"
                                                            name="email" value="{{Auth::guard('customer')->user()->email}}">
                                                        @error('email')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="number" placeholder="Phone*" id="email2" name="phone"
                                                            value="{{Auth::guard('customer')->user()->phone}}">
                                                        @error('phone')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <input type="text" placeholder="Address*" id="Adress" name="address"
                                                            value="{{Auth::guard('customer')->user()->address}}">
                                                        @error('address')
                                                            <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="note-area">
                                                            <textarea name="notes"
                                                                placeholder="Additional Information"></textarea>
                                                            @error('notes')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="biling-item-3">
                                            <input type="hidden" name="ship_to_different" id="ship_to_different" value="0">
                                            <input id="toggle4" type="checkbox"
                                                onclick="$('#ship_to_different').val(this.checked ? 1 : 0)">
                                            <label class="fontsize" for="toggle4">Ship to a Different Address?</label>
                                            <div class="billing-adress" id="open4">
                                                <div class="contact-form form-style">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="First Name*" id="fname6"
                                                                name="ship_fname">
                                                            @error('ship_fname')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Last Name*" id="fname7"
                                                                name="ship_lname">
                                                            @error('ship_lname')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <select name="ship_country" id="Country"
                                                                class="form-control ship_country">
                                                                <option value="">Select Country</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('ship_country')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <select id="City" name="ship_city"
                                                                class=" ship_city form-control ">
                                                                <option value="">Select Country</option>
                                                            </select>
                                                            @error('ship_city')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>

                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="number" placeholder="Postcode / ZIP*" id="Post1"
                                                                name="ship_zip">
                                                            @error('ship_zip')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Company Name*" id="Company1"
                                                                name="ship_company">
                                                            @error('ship_company')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="email" placeholder="Email Address*" id="email5"
                                                                name="ship_email">
                                                            @error('ship_email')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="number" placeholder="Phone*" id="phone1"
                                                                name="ship_phone">
                                                            @error('ship_phone')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <input type="text" placeholder="Address*" id="Adress1"
                                                                name="ship_address">
                                                            @error('ship_address')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="cout-order-area">
                                    <h3>Your Order</h3>
                                    <div class="oreder-item">
                                        <div class="title">
                                            <h2>Products <span>Subtotal</span></h2>
                                        </div>
                                        @foreach ($carts as $cart)
                                            <div class="oreder-product">
                                                <div class="images">
                                                    <span>
                                                        <img src="{{asset('uploads/product/preview/' . $cart->rel_to_product->preview)}}"
                                                            alt="">
                                                    </span>
                                                </div>
                                                <div class="product">
                                                    <ul>
                                                        <li class="first-cart">
                                                            {{Str::substr($cart->rel_to_product->product_name, 0, 10) . '..'}}({{$cart->quantity}})
                                                        </li>
                                                        <li>
                                                            <div class="rating-product">
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <span>15</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <span>&#2547;{{$cart->rel_to_product->after_discount * $cart->quantity}}</span>
                                            </div>
                                        @endforeach

                                        <!-- Shipping -->
                                        <div class="my-3">
                                            <div class="title s2">
                                                <h2>Discount<span>&#2547;{{session('discount')}}</span></h2>
                                            </div>
                                        </div>
                                        <div class="mt-3 mb-3">
                                            <div class="title border-0">
                                                <h2>Delivery Charge</h2>
                                            </div>
                                            <ul>
                                                <li class="free">
                                                    <input data-charge="{{session('final_total')}}" id="Free" type="radio"
                                                        name="charge" class="charge" value="80">

                                                    <label " for=" Free">Inside City: <span>&#2547; 80</span></label>

                                                </li>
                                                <li class="free">
                                                    <input data-charge="{{session('final_total')}}" id="Local" type="radio"
                                                        name="charge" class="charge" value="120">

                                                    <label for="Local">Outside City: <span>&#2547; 120</span></label>

                                                </li>
                                                @error('charge')
                                                    <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </ul>
                                        </div>
                                        <div class="title s2">
                                            <h2>Total<span>&#2547;<span id="total">{{session('final_total')}}</span></span>
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="caupon-wrap s5">
                                    <div class="payment-area">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="payment-option" id="open5">
                                                    <h3>Payment</h3>
                                                    <div class="payment-select">
                                                        <ul>
                                                            <li class="">
                                                                <input id="remove" type="radio" name="payment_method"
                                                                    value="1">

                                                                <label for="remove">Cash on Delivery</label>
                                                            </li>
                                                            <li class="">
                                                                <input id="add" type="radio" name="payment_method"
                                                                    checked="checked" value="2">

                                                                <label for="add">Pay With SSLCOMMERZ</label>
                                                            </li>
                                                            <li class="">
                                                                <input id="getway" type="radio" name="payment_method"
                                                                    value="3">

                                                                <label for="getway">Pay With STRIPE</label>
                                                            </li>
                                                            @error('payment_method')
                                                                <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" name="discount" value="{{session('discount')}}">
                                                    <input type="hidden" name="total" value="{{session('final_total')}}">
                                                    <div id="open6" class="payment-name active">
                                                        <div class="contact-form form-style">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-12">
                                                                    <div class="submit-btn-area text-center">
                                                                        <button class="theme-btn" type="submit">Place
                                                                            Order</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- wpo-checkout-area end-->

    </div>
@endsection
@section('footer_scrtipt')
    <script>
        $('.charge').click(function () {
            var charge = $(this).val();
            var total = $(this).attr('data-charge');
            var total = parseInt(total) + parseInt(charge);
            $('#total').html(total);
        })
    </script>
    <script>
        $(document).ready(function () {
            $('#set_country').select2();
            $('#city').select2();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.ship_country').select2();
            $('.ship_city').select2();
        });
    </script>
    <script>
        $('.set_country').change(function () {
            var country_id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getcity',
                data: { 'country_id': country_id },
                success: function (data) {
                    $('.city').html(data);
                }
            })

        })

    </script>
    <script>
        $('.ship_country').change(function () {
            var country_id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getshipcity',
                data: { 'country_id': country_id },
                success: function (data) {
                    $('.ship_city').html(data);
                }
            })

        })

    </script>
@endsection