@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Update Faveicon</h3>
                </div>
                <div class="card-body">
                    @if (session('faveion_update'))
                        <div class="alert alert-success">{{session('faveion_update')}}</div>
                    @endif
                    <form action="{{route('faveicon.update', $faveicon->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="text" class="form-label">Website Title</label>
                            <input type="text" name="title" class="form-control" value="{{$faveicon->title}}" id="">
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Faveicon</label>
                            <input type="file" name="logo" class="form-control" id="" onchange="document.getElementById('photo').src= window.URL.createObjectURL(this.files[0])">
                            <div class="mt-3">
                                <img src="{{asset('uploads/faveicon/'.$faveicon->logo)}}" width="100px" alt="" id="photo">
                            </div>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                             <a href="{{route('logo')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection