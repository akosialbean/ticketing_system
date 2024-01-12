@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
    <div class="card">
        <div class="card-header"><strong>New Ticket</strong></div>
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

            <form action="/adduser" method="POST">
                @csrf
                @method('POST')
                <div class="mb-3">
                    <label for="t_title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="t_title" name="t_title" required>
                </div>
        
                <div class="mb-3">
                    <label for="t_description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" id="t_description" name="t_description" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="t_todepartment" class="form-label">Category</label>
                    <select class="form-select" name="t_todepartment" id="u_department" required>
                        <option value="">--</option>
                        @foreach($categories as $category)
                            <option value="{{$category->c_id}}">{{$category->c_description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="u_email" class="form-label">To</i></label>
                    <select class="form-select" name="u_department" id="u_department" required>
                        <option value="">--</option>
                        @foreach($departments as $department)
                            <option value="{{$department->d_id}}">{{$department->d_code}} - {{$department->d_description}}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>
  
@endsection