@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Faveicon List</h3>
                </div>
                <div class="card-body">
                    @if (session('faveicon_delete'))
                        <div class="alert alert-success">{{session('faveicon_delete')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Faveicon</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($faveicons as $faveicon)
                            <tr>
                                <td>
                                    <img src="{{asset('uploads/faveicon/' . $faveicon->logo)}}" alt="">
                                </td>
                                <td>{{$faveicon->title}}</td>
                                <td>
                                    <input type="checkbox" {{$faveicon->status == 1 ? 'checked' : ' '}} name="" id=""
                                        data-id="{{$faveicon->id}}" class="status" data-toggle="toggle"
                                        value="{{$faveicon->status}}">
                                </td>
                                <td>
                                    <a href="{{route('faveicon.edit', $faveicon->id)}}" class="btn btn-primary btn-icon">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <a href="{{route('faveicon.delete', $faveicon->id)}}" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </table>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h3>Logo List</h3>
                </div>
                <div class="card-body">
                    @if (session('logo_delete'))
                        <div class="alert alert-success">{{session('logo_delete')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Logo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($logos as $logo)
                            <tr>
                                <td>
                                    <img src="{{asset('uploads/logo/' . $logo->logo)}}" alt="">
                                </td>
                                <td>
                                    <input type="checkbox" {{$logo->status == 1 ? 'checked' : ' '}} name="" id=""
                                        data-id="{{$logo->id}}" class="status1" data-toggle="toggle" value="{{$logo->status}}">
                                </td>
                                <td>
                                    <a href="{{route('logo.delete', $logo->id)}}" class="btn btn-danger btn-icon">
                                        <i data-feather="trash"></i>
                                    </a>
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
                    <h5>Add New Faveicon</h5>
                </div>
                <div class="card-body">
                    @if (session('faveicon_add'))
                        <div class="alert alert-success">{{session('faveicon_add')}}</div>
                    @endif
                    <form action="{{route('faveicon.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Website Title</label>
                            <input type="text" name="title" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <label for="file" class="form-label">Website Faveicon</label>
                            <input type="file" name="faveicon_logo" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Faveicon</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h5>Add New Logo</h5>
                </div>
                <div class="card-body">
                    @if (session('logo_add'))
                        <div class="alert alert-success">{{session('logo_add')}}</div>
                    @endif
                    <form action="{{route('logo.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="file" class="form-label">Website Logo</label>
                            <input type="file" name="logo" class="form-control" id="">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Add Logo</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_script')
    <script>
        $('.status').change(function () {

            if ($(this).val() != 1) {
                $(this).attr('value', 1)
            }
            else {
                $(this).attr('value', 0)
            }
            var faveicon_id = $(this).attr('data-id');
            var status = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getstatus-faveicon',
                data: { 'faveicon_id': faveicon_id, 'status': status },
                success: function (data) {

                }
            })

        })
    </script>
    <script>
        $('.status1').change(function () {

            if ($(this).val() != 1) {
                $(this).attr('value', 1)
            }
            else {
                $(this).attr('value', 0)
            }
            var logo_id = $(this).attr('data-id');
            var status = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getstatus-logo',
                data: { 'logo_id': logo_id, 'status': status },
                success: function (data) {

                }
            })

        })
    </script>
@endsection