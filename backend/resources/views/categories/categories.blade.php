@extends('layouts.app')

@section('title', 'Ticketing System')

<!-- --------------------------------------------------------- -->

@section('content')
    <div class="container my-5 py-5">
        <div class="card">
            <div class="card-header bg-dark">
                <div class="float-start"><a href="/newcategory" class="btn btn-sm btn-primary float-start" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Category"><i class="bi bi-plus-circle"></i></a></div>
                <div class="float-end">@include('_parts.c_search')</div>
            </div>
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
                            <td class="text-center">{{$category->c_id}}</td>
                            <td class="text-center">{{$category->c_code}}</td>
                            <td class="text-center">{{$category->c_description}}</td>
                            <td class="text-center">
                                @if($category->c_status == 1)
                                    Active
                                @else
                                    Disabled
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/category/{{$category->c_id}}" class="btn btn-sm btn-primary"><i class="bi bi-three-dots-vertical"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{$categories->links()}}
            </div>
        </div>
    </div>
@endsection