@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Product List</h3>
                    <a href="{{route('product.add')}}" class="btn btn-primary"><i data-feather="plus"></i> Add New
                        Product</a>
                </div>
                <div class="card-body">
                    @if (session('product_delete'))
                        <div class="alert alert-success mt-2">{{session('product_delete')}}</div>   
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>price</th>
                            <th>Discount</th>
                            <th>After Discout</th>
                            <th>Preview</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($products as $sl => $product)
                            <tr>
                                <td>{{$sl + 1}}</td>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->discount}}%</td>
                                <td>{{$product->after_discount}}</td>
                                <td>
                                    <img src="{{asset('uploads/product/preview/' . $product->preview)}}" height="100"
                                        width="100" alt="">
                                </td>
                                <td>
                                    <input type="checkbox" {{$product->status == 1 ? 'checked' : ''}} name="" id=""
                                        data-id="{{$product->id}}" class="status" data-toggle="toggle"
                                        value="{{$product->status}}">
                                </td>
                                <td>
                                    <a href="{{route('add.inventory', $product->id)}}" class="btn btn-info btn-icon">
                                        <i data-feather="layers"></i>
                                    </a>
                                    <a href="{{route('product.edit', $product->id)}}" class="btn btn-primary btn-icon">
                                        <i data-feather="eye"></i>
                                    </a>
                                    <a href="" class="btn btn-danger btn-icon del_btn"
                                        data-link="{{route('product.delete', $product->id)}}">
                                        <i data-feather="trash"></i>
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
@section('footer_script')
    <script>
        $('.status').change(function () {

            if ($(this).val() != 1) {
                $(this).attr('value', 1)
            }
            else {
                $(this).attr('value', 0)
            }
            var product_id = $(this).attr('data-id');
            var status = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/getstatus',
                data: { 'product_id': product_id, 'status': status },
                success: function (data) {

                }
            })

        })
    </script>
    <script>
        $('.del_btn').click(function (e) {
            e.preventDefault();
            var link = $(this).attr('data-link');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = link;
                }
            });

        })
    </script>

@endsection