@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Sub Category</h3>
                </div>
                <div class="card-body">
                    @if (session('sub_category_store'))
                        <div class="alert alert-success">{{session('sub_category_store')}}</div>
                    @endif
                    @if (session('exist_category'))
                        <div class="alert alert-danger mt-2">{{session('exist_category')}}</div>
                    @endif
                    <form action="{{route('sub.category.update', $sebcategory->id)}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <select name="category" id="category_id" class="form-control">
                                <option value="">Sub Category</option>
                                @foreach ($categories as $category)
                                    <option {{$sebcategory->category_id == $category->id ? 'selected' : ''}}
                                        value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">SubCategory Name</label>
                            <input type="text" name="sub_category" id="" class="form-control"
                                value="{{$sebcategory->sub_category}}">
                            @error('sub_category')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add SubCategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection