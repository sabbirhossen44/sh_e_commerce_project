@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-10 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Website Information</h3>
                </div>
                <div class="card-body">
                    <table class="table  table-hover">
                        <tr>
                            <td>Header top_title</td>
                            <td>:</td>
                            <td>{{$webInfo->top_title}}</td>
                        </tr>
                        <tr>
                            <td>Footer Title</td>
                            <td>:</td>
                            <td>{{$webInfo->footer_title}}</td>
                        </tr>
                        <tr>
                            <td>Web Number</td>
                            <td>:</td>
                            <td>{{$webInfo->web_number}}</td>
                        </tr>
                        <tr>
                            <td>Phone Number1</td>
                            <td>:</td>
                            <td>{{$webInfo->phone_number1}}</td>
                        </tr>
                        <tr>
                            <td>Phone Number2</td>
                            <td>:</td>
                            <td>{{$webInfo->phone_number2}}</td>
                        </tr>
                        <tr>
                            <td>Email1</td>
                            <td>:</td>
                            <td>{{$webInfo->email1}}</td>
                        </tr>
                        <tr>
                            <td>Email1</td>
                            <td>:</td>
                            <td>{{$webInfo->email2}}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td>{{$webInfo->address}}</td>
                        </tr>
                        <tr>
                            <td>Facebook Link</td>
                            <td>:</td>
                            <td><a href="{{$webInfo->facebook}}">{{$webInfo->facebook}}</a></td>
                        </tr>
                        <tr>
                            <td>Instagram Link</td>
                            <td>:</td>
                            <td><a href="{{$webInfo->instagram}}">{{$webInfo->instagram}}</a></td>
                        </tr>
                        <tr>
                            <td>Linkedin Link</td>
                            <td>:</td>
                            <td><a href="{{$webInfo->linkedin}}">{{$webInfo->linkedin}}</a></td>
                        </tr>
                        <tr>
                            <td>Twitter Link</td>
                            <td>:</td>
                            <td><a href="{{$webInfo->twitter}}">{{$webInfo->twitter}}</a></td>
                        </tr>
                    </table>
                    <div class="mt-3">
                        <a href="{{route('webInfo.edit', $webInfo->id)}}" class="btn btn-primary">Edit</a>
                        <a href="{{route('logo')}}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection