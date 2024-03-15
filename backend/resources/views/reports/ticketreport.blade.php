@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')

<div class="container-fluid mt-5 pt-5">
    <div class="card">
        <div class="card-header bg-dark text-light"><strong class="small"><i class="bi bi-table me-2"></i>Reports</strong></div>
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <form action="/report/generate" method="POST">
                                @csrf
                                @method('POST')
                                <div class="col-md-3 col-lg-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><strong>From</strong></span>
                                        <input type="date" name="datefrom" id="datefrom" class="form-control form-control-sm" required>
                                    </div>                                    
                                </div>
        
                                <div class="col-md-3 col-lg-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><strong>To</strong></span>
                                        <input type="date" name="dateto" id="dateto" class="form-control form-control-sm" required>
                                    </div>
                                </div>
        
                                <div class="col-md-3 mb-3 col-lg-4 clearfix">
                                    <button type="submit" class="btn btn-sm btn-warning float-start" onclick="disablebtn()"><strong class="small"><i class="bi bi-funnel me-2"></i>Generate Report</strong></button>

                                    @if($reports)
                                        <a href="/report/export" class="btn btn-sm btn-success float-end"><strong class="small"><i class="bi bi-table me-2"></i>Download Report</strong></a>
                                    @endif
                                </div>
                            </form>

                            <div class="col-md-4">
                                
                        </div>
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