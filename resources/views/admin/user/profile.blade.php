@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Profile update</h6>
                    @if (session('user_update'))
                        <div class="alert alert-success">{{session('user_update')}}</div>

                    @endif
                    <form class="forms-sample" action="{{route('user.info.update')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Name</label>
                            <input type="text" class="form-control" name="name" value="{{Auth::user()->name}}">
                            @error('name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" name="email" value="{{Auth::user()->email}}">
                            @error('email')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Password update</h6>
                    @if (session('password_update'))
                        <div class="alert alert-success">{{session('password_update')}}</div>
                    @endif
                    @if (session('password_not_match'))
                        <div class="alert alert-danger">{{session('password_not_match')}}</div>
                    @endif
                    <form class="forms-sample" action="{{route('user.password.update')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Old Password</label>
                            <input type="password" class="form-control" name="old_password">
                            @error('old_password')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">New Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                            @error('password_confirmation')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">profile photo update</h6>
                    @if (session('photo_update'))
                        <div class="alert alert-success">{{session('photo_update')}}</div>
                    @endif
                    <form class="forms-sample" action="{{route('user.photo.update')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputUsername1">Upload Photo</label>
                            <input type="file" class="form-control" name="photo" required>
                            @error('photo')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                    </form>
                </div>
            </div>
        </div>
       
    </div>
@endsection