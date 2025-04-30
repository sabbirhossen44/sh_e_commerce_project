@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-md-8">
            @can('color_access')
                <div class="card bg-light">
                    <div class="card-header">
                        <h3>Color List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('color_delete'))
                            <div class="alert alert-success">{{session('color_delete')}}</div>
                        @endif
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
                                        <i
                                            style="display: inline-block; width: 50px; height: 30px; background: {{$color->color_name == 'N/A' ? ' ' : $color->color_code}}; color:{{$color->color_name == 'N/A' ? '' : 'transparent'}};">{{$color->color_name == 'N/A' ? $color->color_name : 'Color' }}</i>
                                    </td>
                                    <td>
                                        @can('color_delete')
                                            <a href="{{route('color.delete', $color->id)}}" class="btn btn-danger btn-icon">
                                                <i data-feather="trash"></i>
                                            </a>
                                        @else
                                            No Permission
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            @else
                <h3 class="text-warning"> You don't have to access this page</h3>
            @endcan

            @can('size_access')
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Sizes List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('size_delete'))
                            <div class="alert alert-success">{{session('size_delete')}}</div>
                        @endif
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-md-6 mt-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{$category->category_name}}</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Size Name</th>
                                                    <th>Action</th>
                                                </tr>
                                                @foreach (App\Models\size::where('category_id', $category->id)->get() as $size)
                                                    <tr>
                                                        <td>{{$size->size_name}}</td>
                                                        <td>
                                                            @can('size_delete')
                                                                <a href="{{route('variation.delete', $size->id)}}"
                                                                    class="btn btn-danger btn-icon">
                                                                    <i data-feather="trash"></i>
                                                                </a>
                                                            @else
                                                                No Permission
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endcan

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
                    @can('color_add')
                        <form action="{{route('color.store')}}" method="post">
                            @csrf
                    @endcan
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
                    @can('size_add')
                        <form action="{{route('size.store')}}" method="post">
                            @csrf
                    @endcan
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