@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-3">
        <div class="card">
            <div class="card-header">Departments</div>
            <div class="card-body">
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

                <a href="/newdepartment" class="btn btn-sm btn-primary my-3">Add Department</a>
                
                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($departments as $department)
                        <tr>
                            <td>{{$department->d_id}}</td>
                            <td>{{$department->d_code}}</td>
                            <td>{{$department->d_description}}</td>
                            <td>{{$department->d_status}}</td>
                            <td>
                                <button class="btn btn-sm btn-primary">edit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection