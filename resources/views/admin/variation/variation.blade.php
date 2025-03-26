@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Color List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($colors as $color)
                            <tr>
                                <td>{{$color->color_name}}</td>
                                <td>
                                    <i style="width: 30px; height: 30px; background-color: red; "></i>
                                </td>
                                <td>Delete</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Color</h3>
                </div>
                <div class="card-body">
                    @if (session('color_insert'))
                        <div class="alert alert-success">{{session('color_insert')}}</div>
                    @endif
                    <form action="{{route('color.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Color Name</label>
                            <input type="text" name="color_name" class="form-control" id="">
                            @error('color_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Color Code</label>
                            <input type="text" name="color_code" class="form-control" id="">
                            @error('color_code')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Color</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Add Size</h3>
                </div>
                <div class="card-body">
                    @if (session('size_insert'))
                        <div class="alert alert-success">{{session('size_insert')}}</div>
                    @endif
                    <form action="{{route('size.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <select name="category_id" class="form-control" id="">
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Size Name</label>
                            <input type="text" name="size_name" class="form-control" id="">
                            @error('size_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Size</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection