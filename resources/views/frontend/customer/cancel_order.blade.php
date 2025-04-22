@extends('frontend.master')
@section('content')
    <div class="row py-4">
        <div class="col-md-8 m-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="p-2">Order Cancel Request</h3>
                    <h4 class="bg-warning p-2 text-white d-inline-block">Order ID: {{$order->order_id}}</h4>
                </div>
                <div class="card-body">
                    @if (session('send_request'))
                        <div class="alert alert-success">{{session('send_request')}}</div>
                    @endif
                    <form action="{{route('cancel.order.request', $order->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label">Cancel Reason</label>
                            <textarea name="reason" id="" cols="30" rows="8" class="form-control"></textarea>
                            @error('reason')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Images</label>
                            <input type="file" name="image" class="form-control" id="">
                            @error('image')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Send Request</button>
                            <a href="{{route('my.orders')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection