@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center my-5 py-5">
        <div class="card">
            <div class="card-header bg-dark text-light"><strong>Severity</strong></div>
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

                <form action="/severity/{{$severity->s_id}}/edit" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="s_id" value="{{$severity->s_id}}">
                    <div class="mb-3">
                        <label for="s_title" class="form-label">Severity</label>
                        <input type="text" class="form-control" id="s_title" name="s_title" value="{{$severity->s_title}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="s_description" class="form-label">Description</label>
                        <textarea class="form-control" id="s_description" name="s_description" required>{{$severity->s_description}}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="s_responsetime" class="form-label">Response Time (Days)</label>
                        <input type="number" class="form-control" id="s_responsetime" name="s_responsetime" value="{{$severity->s_responsetime}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="s_resolutiontime" class="form-label">Resolution Time (Days)</label>
                        <input type="number" class="form-control" id="s_resolutiontime" name="s_resolutiontime" value="{{$severity->s_resolutiontime}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="s_escalationtime" class="form-label">Escalation Time (Days)</label>
                        <input type="number" class="form-control" id="s_escalationtime" name="s_escalationtime" value="{{$severity->s_escalationtime}}" required>
                    </div>

                    <div class="mb-3">
                        <label for="s_status" class="form-label">Status</label>
                        <select class="form-select" id="s_status" name="s_status" required>
                            <option value="{{$severity->s_status}}">
                                @if($severity->s_status == 1)
                                    Active
                                @else
                                    Disabled
                                @endif
                            </option>
                            <option value="1">Active</option>
                            <option value="2">Disabled</option>
                        </select>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-sm btn-primary" onclick="disablebtn()">Update Severity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection