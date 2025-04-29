@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card mt-4">
                <div class="card-header">
                    <h3>Edit Role</h3>
                </div>
                <div class="card-body">
                    @if (session('role_update'))
                        <div class="alert alert-success">{{session('role_update')}}</div>
                    @endif
                    <form action="{{route('role.update', $roles->id)}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Role Name</label>
                            <input disabled type="text" name="role_name" class="form-control" id="" value="{{$roles->name}}">
                            @error('role_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div>
                                @foreach ($permissions as $permission)
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input {{$roles->hasPermissionTo($permission->name)?'checked' : '';}} type="checkbox" name="permission[]" class="form-check-input"
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
                            <button type="submit" class="btn btn-primary">Update Role</button>
                            <a href="{{route('role.manage')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection