@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')

<div class="container-fluid mt-5 pt-5">
    <div class="card">
        <div class="card-header"><strong class="small"><i class="bi bi-table me-2"></i>Reports</strong></div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <form action="/report/generate" method="POST">
                            @csrf
                            @method('POST')
        
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><strong>From</strong></span>
                                        <input type="date" name="datefrom" id="datefrom" class="form-control form-control-sm" required>
                                    </div>                                    
                                </div>
        
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><strong>To</strong></span>
                                        <input type="date" name="dateto" id="dateto" class="form-control form-control-sm" required>
                                    </div>
                                </div>
        
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-primary"><strong class="small"><i class="bi bi-funnel me-2"></i>Generate</strong></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-2">
                        @if($reports)
                            <a href="/report/export" class="btn btn-sm btn-primary float-end"><strong class="small"><i class="bi bi-table me-2"></i>Export</strong></a>
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