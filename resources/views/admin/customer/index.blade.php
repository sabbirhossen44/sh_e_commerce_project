@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Customer Log Info</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>User ID</th>
                            <th>User Name</th>
                            <th>Model</th>
                            <th>Data</th>
                            <th>Action</th>
                            <th>Time</th>
                        </tr>
                        @foreach ($actions as $action)
                            <tr>
                                <td>{{$action->user_id}}</td>
                                <td>{{$action->re_to_user->name}}</td>
                                <td>{{$action->model}}</td>
                                <td>{{$action->data}}</td>
                                <td>{{$action->action}}</td>
                                <td>{{$action->created_at->diffForHumans()}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="mt-2 d-flex justify-content-end">
                        {{$actions->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection