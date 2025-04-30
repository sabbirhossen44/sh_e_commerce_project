@extends('layouts.admin')
@section('content')
    @can('brand_access')

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Brand List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('brand_delete'))
                            <div class="alert alert-success">{{session('brand_delete')}}</div>
                        @endif
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
                                        <img src="{{asset('uploads/brand/' . $brand->brand_logo)}}" width="150"
                                            class="img-fluid object-contain" alt="">
                                    </td>
                                    <td>
                                        @can('brand_delete')
                                            <a href="" class="btn btn-danger del_btn btn-icon"
                                                data-link="{{route('brand.delete', $brand->id)}}">
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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New Brand</h3>
                    </div>
                    <div class="card-body">
                        @if (session('brand_add'))
                            <div class="alert alert-success">{{session('brand_add')}}</div>
                        @endif
                        @can('brand_add')
                            <form action="{{route('brand.store')}}" method="post" enctype="multipart/form-data">
                                @csrf
                        @endcan
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