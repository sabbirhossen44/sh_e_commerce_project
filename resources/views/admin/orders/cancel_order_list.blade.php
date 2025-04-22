@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Order Cancel Request List</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Order ID</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($cancel_orders as $sl => $cancel_order)
                            <tr>
                                <td>{{$sl + 1}}</td>
                                <td>{{$cancel_order->re_to_order->order_id}}</td>
                                <td>
                                    @php
                                        $order_product =App\Models\OrderProduct::where('order_id', $cancel_order->re_to_order->order_id)->first()
                                    @endphp
                                    {{$order_product->quantity}}
                                </td>
                                <td>{{$cancel_order->re_to_order->total}}</td>
                                <td>
                                    <a href="{{route('cancel.details.view', $cancel_order->id)}}"
                                        class="btn btn-behance btn-icon">
                                        <i data-feather='eye'></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection