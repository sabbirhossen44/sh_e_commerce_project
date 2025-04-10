@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Banner Edit</h3>
                </div>
                <div class="card-body">
                    @if (session('banner_update'))
                    <div class="alert alert-success">{{session('banner_update')}}</div>
                    @endif
                    <form action="{{route('banner.update', $banner->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label">Banner Title</label>
                            <input type="text" name="banner_text" class="form-control" id="" value="{{$banner->title}}">
                            @error('banner_text')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Banner Images</label>
                            <input type="file" name="banner_images" class="form-control" id="" onchange="document.getElementById('img').src= window.URL.createObjectURL(this.files[0])">
                            <div class="mt-3">
                                <img src="{{asset('uploads/banner/'. $banner->image)}}" width="600px" id="img" alt="">
                            </div>
                            @error('banner_images')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{route('banner')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection