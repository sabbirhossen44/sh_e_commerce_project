@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Brand List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Brand Name</th>
                            <th>Brand Logo</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{$brand->brand_name}}</td>
                                <td>
                                    <img src="{{asset('uploads/brand/'.$brand->brand_logo)}}" width="150" class="img-fluid object-contain" alt="">
                                </td>
                                <td>
                                    <a href=""
                                        class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Brand</h3>
                </div>
                <div class="card-body">
                    @if (session('brand_add'))
                        <div class="alert alert-success">{{session('brand_add')}}</div>
                    @endif
                    <form action="{{route('brand.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Brand Name</label>
                            <input type="text" name="brand_name" class="form-control" id="">
                            @error('brand_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Brand Logo</label>
                            <input type="file" name="brand_logo" class="form-control" id="">
                            @error('brand_logo')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Brand</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection