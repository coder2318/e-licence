@extends('layouts/layoutMaster')

@section('title', 'Tables - Basic Tables')

@section('content')
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-header">
            <h5>Table Basic</h5>
            <div class="d-flex align-content-center flex-wrap gap-4 mb-2">
                <a href="{{route('application.create')}}" type="submit" class="btn btn-primary">Add application</a>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table ">
                <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Expert Comment</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($applications as $item)

                <tr>
                    <td> <i class="ti ti-number ti-md text-danger me-4"></i><a href="{{route('application.show', ['application' => $item->id])}}" class="fw-medium">{{$item->id}}</a></td>
                    <td>{{$item->name}}</td>
                    <td>
                        <span class="badge bg-label-info me-1">{{$item->status_text}}</span></td>
                    <td >{{$item->reason_rejected}}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item " href="{{route('application.show', ['application' => $item->id])}}"><i class="ti ti-eye me-1"></i> Show</a>
                                <a class="dropdown-item {{$item->isNew() ? '' : 'disabled'}}" href="{{route('application.edit', ['application' => $item->id])}}"><i class="ti ti-pencil me-1"></i> Edit</a>
                            </div>
                        </div>
                    </td>
                </tr>

                @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

@endsection
