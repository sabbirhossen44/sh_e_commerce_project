@extends('layouts.admin')
@section('content')

    @can('user_access')
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3>User List</h3>
                    </div>
                    <div class="card-body">
                        @if (session('user_delete'))
                            <div class="alert alert-success">{{session('user_delete')}}</div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>SL</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($users as $sl => $user)
                                <tr>
                                    <td>{{$sl + 1}}</td>
                                    <td>
                                        @if ($user->photo)
                                            <img src="{{asset('uploads/user')}}/{{$user->photo}}" width="50" height="50" alt="">
                                        @else
                                            <img src="{{ Avatar::create($user->name)->toBase64()}}" />
                                        @endif
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @can('user_delete')
                                        <a href="{{route('user.delete', $user->id)}}" class="btn btn-danger btn-icon">
                                            <i data-feather="trash"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach 

                        </table>
                    </div>
                </div>
            </div>

            @can('user_add')
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Add New User</h3>
                        </div>
                        <div class="card-body">
                            @if (session('user_add'))
                                <div class="alert alert-success">{{session('user_add')}}</div>
                            @endif
                            <form action="{{route('user.add')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="" value="{{old('name')}}">
                                    @error('name')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" id="" value="{{old('email')}}">
                                    @error('email')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="">
                                    @error('password')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" id="">
                                    @error('password')
                                        <strong class="text-danger">{{$message}}</strong>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Add User</button>
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