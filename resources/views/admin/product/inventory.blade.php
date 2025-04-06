@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Inventory For, <strong>{{$product->product_name}}</strong></h3>
                </div>
                <div class="card-body">
                    @if (session('inventory_delete'))
                        <div class="alert alert-success">{{session('inventory_delete')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Quentity</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($inventories as $inventory)
                        </tr>
                            <td>{{$inventory->rel_to_color->color_name}}</td>
                            <td>{{$inventory->rel_to_size->size_name}}</td>
                            <td>{{$inventory->quentity}}</td>
                            <td>
                                <a href="{{route('inventory.delete', $inventory->id)}}" class="btn btn-danger btn-icon">
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
                    <h3>Add Inventory</h3>
                </div>
                <div class="card-body">
                    @if (session('inventory_insert'))
                        <div class="alert alert-success">{{session('inventory_insert')}}</div>
                    @endif
                    <form action="{{route('inventory.store', $product->id)}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Product</label>
                            <input type="text" disabled name="" id="" class="form-control"
                                value="{{$product->product_name}}">

                        </div>
                        <div class="mb-3">
                            <select name="color_id" id="" class="form-control">
                                <option value="">Select Color</option>
                                @foreach ($colors as $color)
                                    <option value="{{$color->id}}">{{$color->color_name}}</option>
                                @endforeach
                            </select>
                            @error('color_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select name="size_id" id="" class="form-control">
                                <option value="">Select Size</option>
                                @foreach (App\Models\size::where('category_id', $product->category_id)->get() as $size)
                                    <option value="{{$size->id}}">{{$size->size_name}}</option>
                                @endforeach
                            </select>
                            @error('size_id')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Quentity</label>
                            <input type="number" name="quentity" id="" class="form-control" placeholder="Enter Quentity">
                            @error('quentity')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-primary"> Add Inventory</button>
                            <a href="{{route('product.list')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection