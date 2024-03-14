@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-5 pt-5">
    <div class="card w-50">
        <div class="card-header"><strong>New Ticket</strong></div>
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

            <form action="/addticket" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="t_title" class="form-label"><strong>Title</strong></label>
                        <input type="text" class="form-control" id="t_title" name="t_title" required>
                    </div>
            
                    <div class="col-md-12 mb-3">
                        <label for="t_description" class="form-label"><strong>Description</strong></label>
                        <textarea type="text" class="form-control" id="t_description" name="t_description" required></textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="t_category" class="form-label"><strong>Category</strong></label>
                        <select class="form-select" name="t_category" id="t_category" required>
                            <option value="">--</option>
                            @foreach($categories as $category)
                                <option value="{{$category->c_id}}">{{$category->c_description}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="t_todepartment" class="form-label">To</i></label>
                        <select class="form-select" name="t_todepartment" id="t_todepartment" required>
                            <option value="">--</option>
                            @foreach($departments as $department)
                                <option value="{{$department->d_id}}">{{$department->d_code}} - {{$department->d_description}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="t_files" class="small">Max file size: 10MB</label>
                        <input type="file" name="t_files[]" id="t_files" class="form-control form-control-sm" multiple>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" id="submit-btn" class="btn btn-primary btn-sm float-end ms-3" onclick="disablebtn()"><strong class="small"><i class="bi bi-send me-2"></i>Submit</strong></button>
                        <a href="/tickets" class="btn btn-sm btn-danger float-end"><strong class="small"><i class="bi bi-x-circle me-2"></i>Cancel</strong></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function disableSubmitButton() {
        document.getElementById('submit-btn').disabled = true;
    }
</script>
@endsection