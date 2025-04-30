@extends('layouts.admin')
@section('style_content')
    <style>
        div:where(.swal2-container) div:where(.swal2-actions) {
            gap: 10px;
        }
    </style>
@endsection
@section('content')
    @can('roll_access')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Users List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('user_role_delete'))
                            <div class="alert alert-success">{{session('user_role_delete')}}</div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>Users Name</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td class="text-wrap">
                                        @forelse ($user->getRoleNames() as $role)
                                            <span class="badge-secondary p-1 my-1 d-inline-block">{{$role}}</span>
                                        @empty
                                            <span class="badge-info text-white p-1 my-1 d-inline-block">Not Assign</span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-danger btn-icon user_roll_delte"
                                            data-link="{{route('user.role.delete', $user->id)}}">
                                            <i data-feather="trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Role List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('role_delete'))
                            <div class="alert alert-success">{{session('role_delete')}}</div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>Role Name</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td class="text-wrap">
                                        @foreach ($role->getPermissionNames() as $permission)
                                            <span class="badge-secondary p-1 my-1 d-inline-block">{{$permission}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{route('role.edit', $role->id)}}" class="btn btn-primary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-icon roll_delte"
                                            data-link="{{route('role.delete', $role->id)}}">
                                            <i data-feather="trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card ">
                    <div class="card-header">
                        <h3>Assign Role</h3>
                    </div>
                    <div class="card-body">
                        @if (session('assign_rol'))
                            <div class="alert alert-success">{{session('assign_rol')}}</div>
                        @endif
                        <form action="{{route('assign.role')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <select name="user_id" class="form-control" id="">
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <select name="role" class="form-control" id="">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Assign Role</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Add New Permission</h3>
                    </div>
                    <div class="card-body">
                        @if (session('permission_add'))
                            <div class="alert alert-success">{{session('permission_add')}}</div>
                        @endif
                        <form action="{{route('permission.store')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Permission Name</label>
                                <input type="text" name="permission_name" class="form-control" id="" required>
                                @error('permission_name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Add Permission</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Add New Role</h3>
                    </div>
                    <div class="card-body">
                        @if (session('role_add'))
                            <div class="alert alert-success">{{session('role_add')}}</div>
                        @endif
                        <form action="{{route('role.store')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Role Name</label>
                                <input type="text" name="role_name" class="form-control" id="">
                                @error('role_name')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div>
                                    @foreach ($permissions as $permission)
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="permission[]" class="form-check-input"
                                                    value="{{$permission->name}}" id="per{{$permission->id}}">
                                                {{$permission->name}}
                                                <i class="input-frame"></i></label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permission')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Add Role</button>
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
        $('.roll_delte').click(function (e) {
            e.preventDefault(); // Link default behavior বন্ধ
            var link = $(this).attr('data-link'); // Link টা নিবো

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Confirm করলে success alert দেখাবে
                    setTimeout(() => {
                        window.location.href = link;
                    }, 2000);
                    swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Cancel করলে error alert দেখাবে
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });
        });

    </script>
    <script>
        $('.user_roll_delte').click(function (e) {
            e.preventDefault(); // Link default behavior বন্ধ
            var link = $(this).attr('data-link'); // Link টা নিবো

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Confirm করলে success alert দেখাবে
                    setTimeout(() => {
                        window.location.href = link;
                    }, 2000);
                    swalWithBootstrapButtons.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Cancel করলে error alert দেখাবে
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error"
                    });
                }
            });
        });

    </script>
@endsection