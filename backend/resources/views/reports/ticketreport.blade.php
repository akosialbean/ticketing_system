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
                        <div class="col-sm-2">
                            <label for="datefrom">From</label>
                            <input type="date" name="datefrom" id="datefrom" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-2">
                            <label for="dateto">To</label>
                            <input type="date" name="dateto" id="dateto" class="form-control form-control-sm" required>
                        </div>

                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                        </div>
                    </div>
                </form>

                <hr>

                @if($reports)
                    @include('_parts.r_table')
                @endif
            </div>
        </div>
    </div>
</div>

@endsection