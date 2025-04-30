@extends('layouts.admin')
@section('content')
    @can('subcategory_access')
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Sub-Category List</h3>
                        @if (session('category_permanent_delete'))
                            <div class="alert alert-success mt-2">{{session('category_permanent_delete')}}</div>
                        @endif
                        @if (session('sub_category_update'))
                            <div class="alert alert-success mt-2">{{session('sub_category_update')}}</div>
                        @endif



                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($categories as $category)
                                <div class="col-md-6 my-2">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{$category->category_name}}</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Sub Category</th>
                                                    <th>Action</th>
                                                </tr>
                                                @forelse (App\Models\Subcategory::where('category_id', $category->id)->get() as $subcategory)
                                                    <tr>
                                                        <td>{{$subcategory->sub_category}}</td>
                                                        <td>
                                                            @can('subcategory_edit')
                                                                <a href="{{route('sub.category.edit', $subcategory->id)}}"
                                                                    class="btn btn-primary btn-icon">
                                                                    <i data-feather="edit"></i>
                                                                </a>
                                                            @else
                                                                <a title="No Permission" href="" class="btn btn-primary btn-icon">
                                                                    <i data-feather="edit"></i>
                                                                </a>
                                                            @endcan
                                                            @can('subcategory_delete')
                                                                <a href="" class="btn btn-danger btn-icon del_btn"
                                                                    data-link="{{route('sub.category.delete', $subcategory->id)}}" <i
                                                                    data-feather="trash"></i>
                                                                </a>
                                                            @else
                                                                <a title="No Permission" href="" class="btn btn-danger btn-icon">
                                                                    <i data-feather="trash"></i>
                                                                </a>
                                                            @endcan

                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center">No SubCategory found</td>
                                                    </tr>
                                                @endforelse
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New Sub Category</h3>
                    </div>
                    <div class="card-body">
                        @if (session('sub_category_store'))
                            <div class="alert alert-success">{{session('sub_category_store')}}</div>
                        @endif
                        @if (session('exist'))
                            <div class="alert alert-danger mt-2">{{session('exist')}}</div>
                        @endif
                        @can('subcategory_add')
                            <form action="{{route('sub.category.store')}}" method="post">
                                @csrf
                        @endcan
                            <div class="mb-3">
                                <select name="category" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">SubCategory Name</label>
                                <input type="text" name="sub_category" id="" class="form-control">
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
    @else
        <h3 class="text-warning"> You don't have to access this page</h3>
    @endcan

@endsection
@section('footer_script')
    <script>
        $('.del_btn').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('data-link');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });

        })
    </script>
@endsection