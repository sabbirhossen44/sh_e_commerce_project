<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from wpocean.com/html/tf/themart/forgot.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:45 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="wpOceans">
    @php
        $faveicon = App\Models\Faveicon::where('status', 1)->first();
       @endphp
    @if ($faveicon)
        <link rel="shortcut icon" type="image/png" href="{{asset('uploads/faveicon/' . $faveicon->logo)}}">
        <title>{{$faveicon->title}}</title>
    @else
        <link rel="shortcut icon" type="image/png" href="{{asset('frontend')}}/images/favicon.png">
        <title>Sabbir-SH Shop: Login</title>
    @endif
    <link href="{{asset('frontend/')}}/css/themify-icons.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/flaticon_ecommerce.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/animate.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/owl.theme.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/slick.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/slick-theme.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/swiper.min.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/owl.transitions.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/jquery.fancybox.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/css/odometer-theme-default.css" rel="stylesheet">
    <link href="{{asset('frontend/')}}/sass/style.css" rel="stylesheet">
</head>

<body>

    <!-- start page-wrapper -->
    <div class="page-wrapper">
        <!-- start preloader -->
        <div class="preloader">
            <div class="vertical-centered-box">
                <div class="content">
                    <div class="loader-circle"></div>
                    <div class="loader-line-mask">
                        <div class="loader-line"></div>
                    </div>
                    <img src="{{asset('frontend/')}}/images/preloader.png" alt="">
                </div>
            </div>
        </div>
        <!-- end preloader -->

        <!-- login-area start -->
        <div class="tp-login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <form class="tp-accountWrapper" action="{{route('reset.email.link.send')}}" method="post">
                            @csrf
                            <div class="tp-accountInfo">
                                <div class="tp-accountInfoHeader">
                                    @php
                                        $logo = App\Models\Logo::where('status', 1)->first();
                                    @endphp
                                    @if ($logo)
                                        <a class="navbar-brand" href="{{route('welcome')}}"><img
                                                src="{{asset('uploads/logo/' . $logo->logo)}}" alt="logo" width="200"></a>
                                    @else
                                        <a class="navbar-brand" href="{{route('welcome')}}"><img
                                                src="{{asset('frontend')}}/images/logo-2.svg" alt="logo"></a>
                                    @endif
                                    {{-- <a href="index.html"><img src="{{asset('frontend/')}}/images/logo-2.svg"
                                            alt=""> </a> --}}
                                    {{-- <a class="tp-accountBtn" href="{{route('customer.register')}}">
                                        <span class="">Create Account</span> --}}
                                    </a>
                                </div>
                                <div class="image">
                                    <img src="{{asset('frontend/')}}/images/login.svg" alt="">
                                </div>
                                <div class="back-home">
                                    <a class="tp-accountBtn" href="{{route('welcome')}}">
                                        <span class="">Back To Home</span>
                                    </a>
                                </div>
                            </div>
                            <div class="tp-accountForm form-style">
                                <div class="fromTitle">
                                    <h2>Resend Email Verification Link</h2>
                                    <p>Sign into your pages account</p>
                                    @if (session('success'))
                                        <div class="alert alert-success">{{session('success')}}</div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <label>Email</label>
                                        <input type="text" id="email" name="email" placeholder="demo@gmail.com">
                                        @error('email')
                                            <strong class="text-danger">{{$message}}</strong>
                                        @enderror
                                        @if (session('notexist'))
                                            <strong class="text-danger">{{session('notexist')}}</strong>
                                        @endif
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <button type="submit" class="tp-accountBtn">Resend Email Verification Link</button>
                                    </div>
                                </div>

                                {{-- <p class="subText">Don't have an account? <a
                                        href="{{route('customer.register')}}">Create free
                                        account</a></p> --}}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- login-area end -->


    </div>
    <!-- end of page-wrapper -->

    <!-- All JavaScript files
    ================================================== -->
    <script src="{{asset('frontend/')}}/js/jquery.min.js"></script>
    <script src="{{asset('frontend/')}}/js/bootstrap.bundle.min.js"></script>
    <!-- Plugins for this template -->
    <script src="{{asset('frontend/')}}/js/modernizr.custom.js"></script>
    <script src="{{asset('frontend/')}}/js/jquery.dlmenu.js"></script>
    <script src="{{asset('frontend/')}}/js/jquery-plugin-collection.js"></script>
    <!-- Custom script for this template -->
    <script src="{{asset('frontend/')}}/js/script.js"></script>
</body>


<!-- Mirrored from wpocean.com/html/tf/themart/forgot.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 15 Jun 2023 08:56:45 GMT -->

</html>