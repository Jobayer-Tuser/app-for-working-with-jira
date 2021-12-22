@extends('layouts.app')
@section('title', 'Project list')

@section('breadcrumb-main', 'Project')
@section('breadcrumb-sub', 'list')

@section('content')

@push('css')
    <style>
        .myClass{
            padding: 0.25rem 0.5rem !important;
        }
    </style>
@endpush

<div class="row">
    <form action="">
        <div class="d-flex justify-content-end">
            <div style="margin-right: 1rem; " class="mb-3 col-md-2">
                <select class="form-control myClass " data-trigger name="choices-single-default"
                placeholder="Search Project">
                <option value="">Project Type</option>
                    <option value="Choice 1">Choice 1</option>
                    <option value="Choice 2">Choice 2</option>
                    <option value="Choice 3">Choice 3</option>
                </select>
            </div>
            <div class="ml-2">

                <button class="btn btn-sm btn-primary">Find</button>
            </div>

        </div>
    </form>
    <form method="POST" action="{{ route('project.sync') }}">
        @csrf
        <div class="ml-2">
            <button class="btn btn-sm btn-primary">Sync</button>
        </div>

    </form>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="projectID" class="form-check-input" /></th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Key</th>
                            <th>Type</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if ( ! empty($projects) )
                            @foreach ($projects as $each)
                                <tr>
                                    <td><input type="checkbox" name="projectID" class="form-check-input" /></td>
                                    <td><a href="https://ollyo.atlassian.net/browse/{{ $each->project_key }}" target="_blank"><span class="inv-number">#{{ $each->project_id }}</span></a></td>
                                    <td>{{ $each->project_name }}</td>
                                    <td><span class="badge bg-success">{{ $each->project_key }}</span></td>
                                    <td><span class="badge bg-dark">{{ $each->project_type }}</span></td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-soft-dark">{{ $each->project_status_on_pmo }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- {{ $projects->links() }} --}}
            </div>
        </div>
    </div>
</div>

@endsection
