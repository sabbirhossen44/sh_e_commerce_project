@extends('layouts.admin')
@section('content')
    @can('banner_access')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Banner List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('banner_delete'))
                            <div class="alert alert-success">{{session('banner_delete')}}</div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>
                                        <img src="{{asset('uploads/banner/' . $banner->image)}}" alt="">
                                    </td>
                                    <td>{{$banner->title}}</td>
                                    <td>
                                        <a href="{{route('banner.edit', $banner->id)}}" class="btn btn-primary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <a href="{{route('banner.delete', $banner->id)}}" class="btn btn-danger btn-icon">
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
                        <h3>Add Banner</h3>
                    </div>
                    <div class="card-body">
                        @if (session('banner_add'))
                            <div class="alert alert-success">{{session('banner_add')}}</div>
                        @endif
                        <form action="{{route('banner.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="text" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" id="">
                                @error('title')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control" id="">
                                @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Page Link</label>
                                <select name="category_id" id="" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary cursor-pointer">Add Banner</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <h3 class="text-warning"> You don't have to access this page</h3>
    @endcan
@endsection