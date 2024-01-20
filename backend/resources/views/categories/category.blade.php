@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header">Category</div>
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

                <div class="row">
                    <div class="col-6 px-5 mx-5 justify-content-center">
                        <form action="/category/{{$category->c_id}}/edit" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="c_id" value="{{$category->c_id}}">
                            <div class="mb-3">
                                <label for="c_code" class="form-label">Category Code</label>
                                <input type="text" class="form-control" id="c_code" name="c_code" value="{{$category->c_code}}" required>
                            </div>
        
                            <div class="mb-3">
                                <label for="c_description" class="form-label">Description</label>
                                <input type="text" class="form-control" id="c_description" name="c_description" value="{{$category->c_description}}" required>
                            </div>

                            <div class="mb-3">
                                <label for="c_status" class="form-label">Status</label>
                                <select name="c_status" id="c_status" class="form-select">
                                    <option value="{{$category->c_status}}">
                                        @if($category->c_status == 1)
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
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection