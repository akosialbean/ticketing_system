@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 9vh;">
        <div class="card">
            <div class="card-header"><strong>New Category</strong></div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="c_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="d_description" name="d_description" required>
                    </div>

                    <div class="mb-3">
                        <label for="c_description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="d_description" name="d_description" required>
                    </div>

                    <div class="mb-3">
                        <label for="c_severity" class="form-label">Severity</label>
                        <select type="text" class="form-control" id="d_description" name="d_description" required>
                            <option value="">--</option>
                        </select>
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