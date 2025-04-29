@extends('layouts.admin')
@section('content')
    @can('trash_category')
        <div class="row">
            <div class="col-md-8">
                <form action="{{route('checked.restore')}}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h3>Trash List</h3>
                        </div>
                        <div class="card-body">
                            @if (session('category_restore'))
                                <div class="alert alert-success">{{session('category_restore')}}</div>

                            @endif
                            @if (session('category_restore_error'))
                                <div class="alert alert-danger">{{session('category_restore_error')}}</div>
                            @endif
                            @if (session('category_permanent_delete'))
                                <div class="alert alert-success">{{session('category_permanent_delete')}}</div>
                            @endif
                            @if (session('soft_restore'))
                                <div class="alert alert-success">{{session('soft_restore')}}</div>
                            @endif
                            <table class="table table-bordered">
                                <tr>
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
                                @forelse ($categories as $sl => $category)
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


                                                <a title="Restore" href="{{route('category.restore', $category->id)}}"
                                                    class="btn btn-success btn-icon">
                                                    <i data-feather="rotate-cw"></i>
                                                </a>
                                            @endcan
                                            @can('category_delete')
                                                <a title="Restore" href="{{route('category.parmarent.delete', $category->id)}}"
                                                    class="btn btn-danger btn-icon">
                                                    <i data-feather="trash"></i>
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-danger">No Category Available</td>
                                    </tr>
                                @endforelse
                            </table>
                            <button type="submit" name="action" value="restore" class="btn btn-success mt-2">Restore
                                All</button>
                            <button type="submit" name="action" value="delete" class="btn btn-danger mt-2">Delete All</button>
                        </div>
                    </div>
                </form>
            </div>
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