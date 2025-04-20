@extends('frontend.master')

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
                                <li>Order Srccess</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <div class="row">
            <div class="col-lg-8 py-3 m-auto">
                <div class="card">
                    <div class="card-header">
                        Order Id: {{session('success')}}
                    </div>
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <img src="{{asset('frontend/images/order.png')}}" class="img-fluid w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection