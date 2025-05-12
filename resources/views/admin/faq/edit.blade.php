@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-md-10 m-auto">
             <div class="card">
                <div class="card-header">
                    <h3>Edit Faq Content</h3>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <form action="{{route('faq.update', $faq->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="text" class="form-label">Faq Question</label>
                            <input type="text" name="question" id="" class="form-control" value="{{$faq->question}}">
                            @error('question')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="text" class="form-label">Faq Answer</label>
                            <textarea name="answer" id="" cols="30" rows="10" class="form-control" >{{$faq->answer}}</textarea>
                            @error('answer')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Faq</button>
                            <a href="{{route('faq.index')}}" class="btn btn-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection