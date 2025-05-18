@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Website Information Edit</h3>
                </div>
                <div class="card-body">
                    @if (session('web_info_update'))
                        <div class="alert alert-success">{{session('web_info_update')}}</div>
                    @endif
                    <form action="{{route('webinfo.update', $webInfo->id)}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="text" class="form-label">Top Title</label>
                                <input type="text" name="top_title" class="form-control" id="" value="{{$webInfo->top_title}}">
                                @error('top_title')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Footer Title</label>
                                <input type="text" name="footer_title" class="form-control" id="" value="{{$webInfo->footer_title}}">
                                @error('footer_title')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Website Number</label>
                                <input type="number" name="web_number" class="form-control" id="" value="{{$webInfo->web_number}}">
                                @error('number')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email1</label>
                                <input type="email" name="email1" class="form-control" id="" value="{{$webInfo->email1}}">
                                @error('email1')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email2</label>
                                <input type="email" name="email2" class="form-control" id="" value="{{$webInfo->email2}}">
                                @error('email2')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone Number1</label>
                                <input type="number" name="phone_number1" class="form-control" id="" value="{{$webInfo->phone_number1}}">
                                @error('phone_number1')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone Number2</label>
                                <input type="number" name="phone_number2" class="form-control" id="" value="{{$webInfo->phone_number2}}">
                                @error('phone_number2')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Address</label>
                                <input type="address" name="address" class="form-control" id="" value="{{$webInfo->address}}">
                                @error('address')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Facebook Link</label>
                                <input type="url" name="facebook" class="form-control" id="" value="{{$webInfo->facebook}}">
                                @error('facebook')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Instagram Link</label>
                                <input type="url" name="instagram" class="form-control" id="" value="{{$webInfo->instagram}}">
                                @error('instagram')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Linkedin Link</label>
                                <input type="url" name="linkedin" class="form-control" id="" value="{{$webInfo->linkedin}}">
                                @error('linkedin')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Twitter Link</label>
                                <input type="url" name="twitter" class="form-control" id="" value="{{$webInfo->twitter}}">
                                @error('twitter')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Information</button>
                                <a href="{{route('logo')}}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection