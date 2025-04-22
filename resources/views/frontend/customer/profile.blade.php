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
                            <li><a href="">Customer Prifile</a></li>
                        </ol>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- end container -->
    </section>
    <!-- end page-title -->
    <div class="container">
        <div class="row py-5">
            @if (session('information_update'))
                <div class="alert alert-success">{{session('information_update')}}</div>
            @endif
            {{-- <div class="col-md-3">
                <div class="card text-center">
                    @if (Auth::guard('customer')->user()->photo)
                        <img src="{{ asset('uploads/customer/' . Auth::guard('customer')->user()->photo) }}" alt="User Image"
                            class="card-img-top w-25 text-center m-auto mt-2 rounded-pill object-cover">
                    @else
                        <img src="{{ Avatar::create(Auth::guard('customer')->user()->fname . ' ' . Auth::guard('customer')->user()->lname)->toBase64()}}"
                            class="card-img-top w-25 m-auto mt-2 text-center" />
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            {{Auth::guard('customer')->user()->fname . ' ' . Auth::guard('customer')->user()->lname}}
                        </h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item py-3 bg-light"><a href="{{route('customer.profile')}}" class="text-dark">Profile</a></li>
                        <li class="list-group-item py-3 bg-light"><a href="{{{route('my.orders')}}}" class="text-dark">My Order</a></li>
                        <li class="list-group-item py-3 bg-light"><a href="" class="text-dark">My Wishlist</a></li>
                        <li class="list-group-item py-3 bg-light"><a href="{{route('customer.logout')}}"
                                class="text-dark">Logout</a></li>
                    </ul>
                </div>
            </div> --}}
            @include('frontend.customer.includes.profile_sidebar')

            
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Update Customer Information</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('customer.profile.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">First Name</label>
                                        <input type="text" name="fname" class="form-control" id="" value="{{Auth::guard('customer')->user()->fname}}">
                                        @error('fname')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Last Name</label>
                                        <input type="text" name="lname" class="form-control" id="" value="{{Auth::guard('customer')->user()->lname}}">
                                        @error('lname')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" id="" disabled value="{{Auth::guard('customer')->user()->email}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="">
                                        @error('password')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Phone</label>
                                        <input type="number" name="phone" class="form-control" id="" value="{{Auth::guard('customer')->user()->phone}}">
                                        @error('phone')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Zip Code</label>
                                        <input type="number" name="zip" class="form-control" id="" value="{{Auth::guard('customer')->user()->zip}}">
                                        @error('zip')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Address</label>
                                        <input type="text" name="address" class="form-control" id=""  value="{{Auth::guard('customer')->user()->address}}">
                                        @error('address')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Photo</label>
                                        <input type="file" name="photo" class="form-control" id="" onchange="document.getElementById('photo').src= window.URL.createObjectURL(this.files[0])">
                                        <div class="mt-3">
                                            <img src="{{asset('uploads/customer/'. Auth::guard('customer')->user()->photo)}}" alt="" id="photo" width="150">
                                        </div>
                                        @error('photo')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection