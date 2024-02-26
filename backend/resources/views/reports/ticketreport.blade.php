@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')

<div class="container mt-5 pt-5">
    <div class="card">
        <div class="card-header">Reports</div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <form action="/report/generate" method="POST">
                            @csrf
                            @method('POST')
        
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="datefrom">From</label>
                                    <input type="date" name="datefrom" id="datefrom" class="form-control form-control-sm" required>
                                </div>
        
                                <div class="col-md-4">
                                    <label for="dateto">To</label>
                                    <input type="date" name="dateto" id="dateto" class="form-control form-control-sm" required>
                                </div>
        
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary">Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        @if($reports)
                            <a href="/report/export" class="btn btn-sm btn-primary float-end">Export</a>
                        @endif
                    </div>
                </div>
                
                <hr>

                @if($reports)
                    @include('_parts.r_table')
                @endif
            </div>
        </div>
    </div>
</div>

@endsection