@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center my-5 py-5">
        <div class="card">
            <div class="card-header"><strong>New Local</strong></div>
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

                <form action="/locals/addlocal" method="POST">
                    @csrf
                    @method('POST')
                    <div class="mb-3">
                        <label for="l_level" class="form-label">Level</label>
                        <select name="l_level" id="" class="form-select form-select-sm">
                            <option value="">--</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="l_department" class="form-label">Department</label>
                        <select name="l_department" id="l_department" class="form-select form-select-sm">
                            <option value="">--</option>
                            @foreach($departments as $department)
                                <option value="{{$department->d_id}}">{{$department->d_code}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="l_user" class="form-label">User (optional)</label>
                        <select name="l_user" id="l_user" class="form-select form-select-sm">
                            <option value="0">all</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->u_fname}} {{$user->u_lname}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="l_number" class="form-label">Local</label>
                        <input type="number" class="form-control" id="l_number" name="l_number" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection