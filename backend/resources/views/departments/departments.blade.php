@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header bg-dark text-light" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Department"><strong>Departments | <a href="/newdepartment" class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i></a></strong></div>
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

                
                
                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Department</th>
                            <th>Email</th>
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
                            <td>{{$department->d_email}}</td>
                            <td>
                                @if($department->d_status == 1)
                                    Active
                                @else
                                    Disabled
                                @endif
                            </td>
                            <td>
                                <a href="/department/{{$department->d_id}}" class="btn btn-sm btn-primary">edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{$departments->links()}}
            </div>

        </div>
    </div>
@endsection