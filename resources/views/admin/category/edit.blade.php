@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6 m-auto">
           
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Category</h3>
                    </div>
                    <div class="card-body">
                        @if (session('category_update'))
                            <div class="alert alert-success px-3">{{session('category_update')}}</div>
                        @endif
                        <form action="{{route('category.update', $category->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Category Name</label>
                                <input type="text" name="category_name" class="form-control" id="" value="{{$category->category_name}}">
                                @error('category_name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                                <div class="my-2">
                                    <img src="{{asset('uploads/category/'.$category->icon)}}" width="60" alt="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Icon</label>
                                <input type="file" name="icon" class="form-control" id="">
                                @error('icon')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update Category</button>
                            </div>
                        </form>
                    </div>
                </div>
        
        </div>
    </div>
@endsection