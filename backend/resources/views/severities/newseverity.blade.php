@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
        <div class="card">
            <div class="card-header"><strong>New Severity</strong></div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="s_severity" class="form-label">Severity</label>
                        <input type="text" class="form-control" id="s_severity" name="s_severity" required>
                    </div>

                    <div class="mb-3">
                        <label for="s_description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="s_description" name="s_description" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection