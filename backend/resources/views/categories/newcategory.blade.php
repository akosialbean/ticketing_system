@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
        <div class="card">
            <div class="card-header"><strong>New Category</strong></div>
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

                <form action="/addcategory" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="c_code" class="form-label">Category Code</label>
                        <input type="text" class="form-control" id="c_code" name="c_code" required>
                    </div>

                    <div class="mb-3">
                        <label for="c_description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="c_description" name="c_description" required>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection