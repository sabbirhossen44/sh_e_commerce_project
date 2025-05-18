@extends('layouts.admin')
@section('content')
    @can('logo_access')
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
                                        @can('logo_edit')
                                            <a href="{{route('faveicon.edit', $faveicon->id)}}" class="btn btn-primary btn-icon">
                                                <i data-feather='edit'></i>
                                            </a>
                                        @endcan
                                        @can('logo_delete')
                                            <a href="{{route('faveicon.delete', $faveicon->id)}}" class="btn btn-danger btn-icon">
                                                <i data-feather="trash"></i>
                                            </a>
                                        @endcan
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
                                        @can('logo_delete')
                                            <a href="{{route('logo.delete', $logo->id)}}" class="btn btn-danger btn-icon">
                                                <i data-feather="trash"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h3>Web Information List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>Header Title</th>
                                <th>Website Number</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach (App\Models\webInformation::all() as $info)
                                <tr>
                                    <td>{{$info->top_title}}</td>
                                    <td>{{$info->web_number}}</td>
                                    <td>{{$info->address}}</td>
                                    <td>
                                        <input type="checkbox" {{$info->status == 1 ? 'checked' : ' '}} name="" id=""
                                            data-id="{{$info->id}}" class="info_status" data-toggle="toggle" value="{{$info->status}}">
                                    </td>
                                    <td>
                                        <a href="{{route('webInfo.view', $info->id)}}" class="btn btn-primary btn-icon">
                                            <i data-feather="eye"></i>
                                        </a>
                                        <a href="{{route('webInfo.edit', $info->id)}}" class="btn btn-secondary btn-icon">
                                            <i data-feather="edit"></i>
                                        </a>
                                        <a href="" class="btn btn-danger btn-icon">
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
                                @error('title')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Website Faveicon</label>
                                <input type="file" name="faveicon_logo" class="form-control" id="">
                                @error('faveicon_logo')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
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
                                @error('logo')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Add Logo</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Web Information</h5>
                    </div>
                    <div class="card-body">
                        @if (session('web_info_add'))
                            <div class="alert alert-success">{{session('web_info_add')}}</div>
                        @endif
                        <form action="{{route('webinformation.store')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="text" class="form-label">Top Title</label>
                                <input type="text" name="top_title" class="form-control" id="">
                                @error('top_title')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Footer Title</label>
                                <input type="text" name="footer_title" class="form-control" id="">
                                @error('footer_title')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="text" class="form-label">Website Number</label>
                                <input type="number" name="web_number" class="form-control" id="">
                                @error('number')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email1</label>
                                <input type="email" name="email1" class="form-control" id="">
                                @error('email1')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Email2</label>
                                <input type="email" name="email2" class="form-control" id="">
                                @error('email2')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone Number1</label>
                                <input type="number" name="phone_number1" class="form-control" id="">
                                @error('phone_number1')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Phone Number2</label>
                                <input type="number" name="phone_number2" class="form-control" id="">
                                @error('phone_number2')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Address</label>
                                <input type="address" name="address" class="form-control" id="">
                                @error('address')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Facebook Link</label>
                                <input type="url" name="facebook" class="form-control" id="">
                                @error('facebook')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Instagram Link</label>
                                <input type="url" name="instagram" class="form-control" id="">
                                @error('instagram')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Linkedin Link</label>
                                <input type="url" name="linkedin" class="form-control" id="">
                                @error('linkedin')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Twitter Link</label>
                                <input type="url" name="twitter" class="form-control" id="">
                                @error('twitter')
                                    <strong class="text-danger">{{$message}}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Add Information</button>
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
        $('.info_status').change(function () {

            if ($(this).val() != 1) {
                $(this).attr('value', 1)
            }
            else {
                $(this).attr('value', 0)
            }
            var info_id = $(this).attr('data-id');
            var status = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getstatus/webinfo',
                data: { 'info_id': info_id, 'status': status },
                success: function (data) {

                }
            })

        })
    </script>
@endsection