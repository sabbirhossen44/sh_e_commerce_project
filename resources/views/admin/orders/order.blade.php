@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>All Orders</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-primary">{{session('success')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Order ID</th>
                            <th>Total</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($orders as $sl => $order)
                            <tr>
                                <td>{{$sl + 1}}</td>
                                <td>{{$order->order_id}}</td>
                                <td>{{$order->total}}</td>
                                <td>{{$order->created_at->diffForHumans()}}</td>
                                <td>
                                    @if ($order->status == 0)
                                        <span class="badge btn bg-secondary text-white">Placed</span>
                                    @elseif ($order->status == 1)
                                        <span class="badge btn bg-primary text-white">Processing</span>
                                    @elseif ($order->status == 2)
                                        <span class="badge btn bg-warning text-white">Shipping</span>
                                    @elseif ($order->status == 3)
                                        <span class="badge btn bg-info text-white">Ready for Deliver</span>
                                    @elseif ($order->status == 4)
                                        <span class="badge btn bg-success text-white">Delivered</span>
                                    @elseif ($order->status == 5)
                                        <span class="badge btn bg-danger text-white">Cancel</span>
                                    @else

                                    @endif
                                </td>
                                <td>
                                    <form action="{{route('order.status.update', $order->id)}}" method="post">
                                        @csrf
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Change Status
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <button name="status" value="0" class="dropdown-item"
                                                    style="background: #{{$order->status == 0 ? 'ddd' : ''}}">Placed</button>
                                                <button name="status" value="1" class="dropdown-item"
                                                    style="background: #{{$order->status == 1 ? 'ddd' : ''}}">Processing</button>
                                                <button name="status" value="2" class="dropdown-item"
                                                    style="background: #{{$order->status == 2 ? 'ddd' : ''}}">Shipping</button>
                                                <button  name="status" value="3" class="dropdown-item"
                                                    style="background: #{{$order->status == 3 ? 'ddd' : ''}}">Ready for
                                                    Deliver</button>
                                                <button  name="status" value="4" class="dropdown-item"
                                                    style="background: #{{$order->status == 4 ? 'ddd' : ''}}">Delivered</button>
                                                <button name="status" value="5" class="dropdown-item"
                                                    style="background: #{{$order->status == 5 ? 'ddd' : ''}}">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection