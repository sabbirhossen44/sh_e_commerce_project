@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Tags List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Tag Name</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($tags as $sl => $tag)
                            <tr>
                                <td>{{$tags->firstitem() + $sl}}</td>
                                <td>{{$tag->tag_name}}</td>
                                <td>
                                    <a href="" class="btn btn-danger btn-icon del_btn" >
                                    <i data-feather="trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="mt-2 d-flex justify-content-end">
                        {{$tags->links()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Tag</h3>
                </div>
                <div class="card-body">
                    @if (session('tag_add'))
                        <div class="alert alert-success">{{session('tag_add')}}</div>
                    @endif
                    <form action="{{route('tag.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label">Tag Name</label>
                            <input type="text" name="tag_name" id="" class="form-control">
                            @error('tag_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Tag</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection