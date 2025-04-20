@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon Edit</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <form action="{{route('coupon.update', $coupon->id)}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Coupon</label>
                            <input type="text" disabled  name="coupon" class="form-control" id="" value="{{$coupon->coupon}}">
                            @error('coupon')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Type</label>
                            <select name="type" id="" class="form-control">
                                @if ($coupon->type == 1)
                                    <option value="1" selected>Percentage</option>
                                    <option value="2">Solid</option>
                                @else
                                    <option value="2" selected>Solid</option>
                                    <option value="1">Percentage</option>
                                @endif
                            </select>
                            @error('type')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Amount</label>
                            <input type="number" name="amount" class="form-control" id="" value="{{$coupon->amount}}">
                            @error('amount')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Validity</label>
                            <input type="date" name="validity" class="form-control" id="" value="{{$coupon->validity}}">
                            @error('validity')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Limit</label>
                            <input type="number" name="limit" class="form-control" id="" value="{{$coupon->limit}}">
                            @error('limit')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Coupon Update</button>
                            <a href="{{route('coupon')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection