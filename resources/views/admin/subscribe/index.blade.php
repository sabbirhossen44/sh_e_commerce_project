@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Subscribe Llist</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <td>SL</td>
                            <td>Email</td>
                            <td>Action</td>
                        </tr>
                        @foreach ($subscribers as $sl =>$subscriber)
                        <tr>
                            <td>{{$sl + 1}}</td>
                            <td>{{$subscriber->email}}</td>
                            <td>
                                <a href=""  class="btn btn-info">Send Offer</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection