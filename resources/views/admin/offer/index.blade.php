@extends('layouts.admin')
@section('style')
    <style>
        .banner-two-wrap {
            /* background: url(../images/banner-bg.jpg); */
            /* */
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Offer 1</h3>
                </div>
                <div class="card-body">
                    @if (session('offer1_update'))
                        <div class="alert alert-success">{{session('offer1_update')}}</div>
                    @endif
                    <form action="{{route('offer1.update', $offer->first()->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="" value="{{$offer->first()->title}}">
                            @error('title')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" id="" value="{{$offer->first()->price}}">
                            @error('price')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Discount Price</label>
                            <input type="number" name="discoutn_price" class="form-control" id=""
                                value="{{$offer->first()->discount_price}}">
                            @error('discoutn_price')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" id="" value="{{$offer->first()->date}}">
                            @error('date')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id=""
                                onchange="document.getElementById('logo').src= window.URL.createObjectURL(this.files[0])">
                            <div class="mt-2">
                                <img src="{{asset('uploads/offer/' . $offer->first()->image)}}" width="300" alt="" id="logo">
                            </div>
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Offer 2</h3>
                </div>
                <div class="card-body">
                    @if (session('offer2_update'))
                        <div class="alert alert-success">{{session('offer2_update')}}</div>
                    @endif
                    <form action="{{route('offer2.update', $offer2->first()->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="" value="{{$offer2->first()->title}}">
                            @error('title')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Sub Title</label>
                            <input type="text" name="sub_title" class="form-control" id="" value="{{$offer2->first()->sub_title}}">
                            @error('sub_title')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="text" class="form-label">Image</label>
                            <input type="file" name="image2" class="form-control" id=""
                                onchange="document.getElementById('logo2').src= window.URL.createObjectURL(this.files[0])">
                            <div class="mt-2">
                                <img src="{{asset('uploads/offer/' . $offer2->first()->image)}}" width="300" alt="" id="logo2">
                            </div>
                            @error('image2')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection