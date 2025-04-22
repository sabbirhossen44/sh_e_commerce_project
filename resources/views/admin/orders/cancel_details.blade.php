@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="">Order Cancel Reason</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Order ID</td>
                            <td>{{$cancel_details->re_to_order->order_id}}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>{{$cancel_details->re_to_order->total}}</td>
                        </tr>
                        <tr>
                            <td>Reason</td>
                            <td>{{$cancel_details->reason}}</td>
                        </tr>
                        <tr>
                            <td>Images</td>
                            <td>
                                @if (!empty($cancel_details->image))
                                    <img src="{{asset('uploads/cancelorder/' . $cancel_details->image)}}">
                                @endif
                            </td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="{{route('order.cancel.lists')}}" class="btn btn-secondary ">Back</a>
                        <a href="{{route('order.cancel.accept', $cancel_details->id)}}" class="btn btn-primary ">Accept</a>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
@endsection