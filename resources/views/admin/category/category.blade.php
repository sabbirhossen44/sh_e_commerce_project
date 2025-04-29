@extends('layouts.admin')
@section('content')
    @can('category_access')
        <div class="row">
            <div class="col-lg-8">
                <form action="{{route('checked.delete')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3>Category List</h3>
                        </div>
                        <div class="card-body">
                            @if (session('category_soft_delete'))
                                <div class="alert alert-success">{{session('category_soft_delete')}}</div>

                            @endif
                            @if (session('soft_delete'))
                                <div class="alert alert-success">{{session('soft_delete')}}</div>

                            @endif
                            <table class="table table-bordered">
                                <tr>
                                    {{-- <th><input type="checkbox" name="" id="chkSelectAll"> Checked All</th> --}}
                                    <th>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="checkbox" id="chkSelectAll" class="form-check-input">
                                                Checked All
                                                <i class="input-frame"></i></label>
                                        </div>
                                    </th>
                                    <th>SL</th>
                                    <th>Category Icon</th>
                                    <th>Category Name</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($categories as $sl => $category)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="checkbox" name="category_id[]" value="{{$category->id}}"
                                                        class="form-check-input chkDel">
                                                    <i class="input-frame"></i></label>
                                            </div>
                                        </td>
                                        <td>{{$sl + 1}}</td>
                                        <td>
                                            <img src="{{asset('uploads/category/' . $category->icon)}}" alt="">
                                        </td>
                                        <td>{{$category->category_name}}</td>
                                        <td>
                                            @can('category_edit')
                                                <a href="{{route('category.edit', $category->id)}}" class="btn btn-primary btn-icon">
                                                    <i data-feather="edit"></i>
                                                </a>
                                            @endcan
                                            @can('category_delete')
                                                <a href="{{route('category.soft.delete', $category->id)}}"
                                                    class="btn btn-danger btn-icon">
                                                    <i data-feather="trash"></i>
                                                </a>
                                            @endcan

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            @can('category_delete')
                                <button type="submit" class="btn btn-danger mt-2">Delete Cheked</button>
                            @endcan
                        </div>
                    </div>
                </form>

            </div>
            @can('add_category')
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New Category</h3>
                        </div>
                        <div class="card-body">
                            @if (session('category_add'))
                                <div class="alert alert-success">{{session('category_add')}}</div>
                            @endif
                            <form action="{{route('category.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" id="">
                                    @error('category_name')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Icon</label>
                                    <input type="file" name="icon" class="form-control" id="">
                                    @error('icon')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Add Category</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    @else
        <h3 class="text-warning"> You don't have to access this page</h3>
    @endcan

@endsection
@section('footer_script')
    <script>
        $("#chkSelectAll").on('click', function () {
            this.checked ? $(".chkDel").prop("checked", true) : $('.chkDel').prop('checked', false);
        })
    </script>
@endsection