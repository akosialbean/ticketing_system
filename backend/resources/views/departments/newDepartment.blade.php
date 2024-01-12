@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
        <div class="card">
            <div class="card-header"><strong>New Department</strong></div>
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

                <form action="/adddepartment" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="d_code" class="form-label">Department Code</label>
                        <input type="text" class="form-control" id="d_code" name="d_code" autofocus required>
                    </div>

                    <div class="mb-3">
                        <label for="d_description" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="d_description" name="d_description" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection