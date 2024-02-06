@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')

<div class="container mt-5 pt-5">
    <div class="card">
        <div class="card-header">Reports</div>
        <div class="card-body">
            <div class="container">
                <form action="/report/generate" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="table">Table</label>
                            <select name="table" id="table" class="form-select" required>
                                <option value="">--</option>
                                <option value="categories">Categories</option>
                                <option value="comments">Comments</option>
                                <option value="departments">Departments</option>
                                <option value="severities">Severities</option>
                                <option value="tickets">Tickets</option>
                                <option value="users">Users</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <label for="datefrom">From</label>
                            <input type="date" name="datefrom" id="datefrom" class="form-control" required>
                        </div>

                        <div class="col-sm-2">
                            <label for="dateto">To</label>
                            <input type="date" name="dateto" id="dateto" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    {{$reports->t_id}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection