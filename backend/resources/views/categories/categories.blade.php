@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header">Categories</div>
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

                <a href="/newcategory" class="btn btn-sm btn-primary my-3">Add Category</a>
                
                <table class="table table-sm table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{$category->c_id}}</td>
                            <td>{{$category->c_code}}</td>
                            <td>{{$category->c_description}}</td>
                            <td>
                                @if($category->c_status == 1)
                                    Active
                                @else
                                    Disabled
                                @endif
                            </td>
                            <td>
                                <a href="/category/{{$category->c_id}}" class="btn btn-sm btn-primary">edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection