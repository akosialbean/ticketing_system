@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success">
                <strong>{{ session()->get('success') }}</strong>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger">
                <strong>{{ session()->get('error') }}</strong>
            </div>
        @endif
        
        <table class="table table-sm table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Category</th>
                    <th>Severity</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{$category->c_id}}</td>
                    <td>{{$category->c_code}}</td>
                    <td>{{$category->c_description}}</td>
                    <td>{{$category->c_severity}}</td>
                    <td>{{$category->c_status}}</td>
                    <td>
                        <button class="btn btn-sm btn-primary">edit</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection