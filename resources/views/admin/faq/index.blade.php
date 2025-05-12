@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>FAQ List</h3>
                    <a href="{{route('faq.create')}}" class="btn btn-primary">Add Faq</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($faqs as $faq)
                            <tr>
                                <td class="text-wrap">{{$faq->question}}</td>
                                <td class="text-wrap">{{$faq->answer}}</td>
                                <td class="d-flex">
                                    <a href="{{route('faq.edit', $faq->id)}}" class="btn btn-primary btn-icon">
                                        <i data-feather="edit"></i>
                                    </a>
                                    <div class="ms-2"></div>
                                    <form action="{{route('faq.destroy', $faq->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-icon"><i
                                                data-feather="trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-danger">No FAQ Available</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection