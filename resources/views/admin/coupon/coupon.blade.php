@extends('layouts.admin')
@section('content')
@can('coupon_access')
<div class="row">
    <div class="col-md-8">
        
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Coupon</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Limit</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($coupons as $sl => $coupon)
                        <tr>
                            <td>{{$sl + 1}}</td>
                            <td>{{$coupon->coupon}}</td>
                            <td>
                                @if ($coupon->type == 1)
                                    percentage (%)
                                @else
                                    Solid (&#2547;)
                                @endif
                            </td>
                            <td>{{$coupon->amount}}</td>
                            <td>{{$coupon->validity}}</td>
                            <td>{{$coupon->limit}}</td>
                            <td>
                                @can('coupon_status')
                                <input type="checkbox" {{$coupon->status == 1 ? 'checked' : ''}}
                                    data-id="{{$coupon->id}}" class="status" data-toggle="toggle"
                                    value="{{$coupon->status}}">
                                @endcan
                            </td>
                            <td>
                                @can('coupon_edit')
                                <a href="{{route('coupon.edit', $coupon->id)}}" class="btn btn-primary btn-icon">
                                    <i data-feather="eye"></i>
                                </a>
                                @endcan

                                @can('coupon_delete')
                                <a href="{{route('coupon.delete', $coupon->id)}}" class="btn btn-danger btn-icon del_btn">
                                    <i data-feather="trash"></i>
                                </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <h5 class="text-center text-danger">Coupon Not Available</h5>
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
        
    </div>
    <div class="col-md-4">
        
        <div class="card">
            <div class="card-header">
                <h3>Add Coupon</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                @can('coupon_add')
                <form action="{{route('coupon.store')}}" method="post">
                    @csrf
                    @endcan
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon</label>
                        <input type="text" name="coupon" class="form-control" id="">
                        @error('coupon')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Type</label>
                        <select name="type" id="" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">Percentage</option>
                            <option value="2">Solid</option>
                        </select>
                        @error('type')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Amount</label>
                        <input type="number" name="amount" class="form-control" id="">
                        @error('amount')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Validity</label>
                        <input type="date" name="validity" class="form-control" id="">
                        @error('validity')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Limit</label>
                        <input type="number" name="limit" class="form-control" id="">
                        @error('limit')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
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
            var coupon_id = $(this).attr('data-id');
            var status = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/couponstatus',
                data: { 'coupon_id': coupon_id, 'status': status },
                success: function (data) {
                    
                }
            })

        })
    </script>
@endsection