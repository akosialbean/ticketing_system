@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5 pt-5">
    <div class="card">
        <div class="card-header bg-dark text-light"><strong>Edit Ticket #{{$ticket->t_id}}</strong></div>
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

            <form action="/ticket/{{$ticket->t_id}}/editticket/edit" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="t_id" class="form-control" value={{$ticket->t_id}}>
                <div class="mb-3">
                    <label for="t_title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="t_title" name="t_title" value="{{$ticket->t_title}}" required>
                </div>
        
                <div class="mb-3">
                    <label for="t_description" class="form-label">Description</label>
                    <textarea type="text" class="form-control" id="t_description" name="t_description" required>{{$ticket->t_description}}</textarea>
                </div>

                <div class="mb-3">
                    <label for="t_category" class="form-label">Category</label>
                    <select class="form-select" name="t_category" id="t_category" required>
                        <option value="{{$ticket->t_category}}">{{$ticket->c_description}}</option>
                        @foreach($categories as $category)
                            <option value="{{$category->c_id}}">{{$category->c_description}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="t_todepartment" class="form-label">To</i></label>
                    <select class="form-select" name="t_todepartment" id="t_todepartment" required>
                        <option value="{{$ticket->t_todepartment}}">{{$ticket->d_code}} - {{$ticket->d_description}}</option>
                        @foreach($departments as $department)
                            <option value="{{$department->d_id}}">{{$department->d_code}} - {{$department->d_description}}</option>
                        @endforeach
                    </select>
                </div>

                <a href="/{{Auth::user()->u_department}}/tickets/alltickets/id/desc" class="btn btn-sm btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary btn-sm" onclick="disablebtn()">Save</button>
            </form>
        </div>
    </div>
</div>
  
@endsection