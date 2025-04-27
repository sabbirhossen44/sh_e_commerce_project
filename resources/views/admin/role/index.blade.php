@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-8"></div>
        <div class="col-lg-4">
            <div class="card">
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
                            <input type="text" name="permission_name" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Permission</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection