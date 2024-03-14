@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center my-5 py-5">
        <div class="card">
            <div class="card-header"><strong>Department</strong></div>
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

                <form action="/department/{{$department->d_id}}/edit" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="d_id" value="{{$department->d_id}}">
                    <div class="mb-3">
                        <label for="d_code" class="form-label">Department Code</label>
                        <input type="text" class="form-control" id="d_code" name="d_code" value="{{$department->d_code}}" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label for="d_description" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="d_description" name="d_description" value="{{$department->d_description}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="d_email" class="form-label">Department Email</label>
                        <input type="email" class="form-control" id="d_email" name="d_email" value="{{$department->d_email}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="d_status" class="form-label">Status</label>
                        <select name="d_status" id="d_status" class="form-select">
                            <option value="{{$department->d_status}}">
                                @if($department->d_status == 1)
                                    Active
                                @else
                                    Disabled
                                @endif
                            </option>
                            <option value="1">Active</option>
                            <option value="2">Disabled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <a href="/departments" class="btn btn-sm btn-danger my-3">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm" onclick="disablebtn()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection