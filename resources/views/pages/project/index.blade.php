@extends('layouts.app')
@section('title', 'Project List')

@section('breadcrumb-main', 'Project')
@section('breadcrumb-sub', 'List')

@section('content')

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                            <h4>Find Task By</h4>
                        </div>
                        <div class="col-xl-6 col-md-6 col-sm-6 col-6 mt-2">
                            <form method="POST" action="{{ route('project.sync') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Sync</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form action="{{ route('project.list') }}">
                        <div class="row ml-3 mt-3">
                            <div class="form-group col-md-2">
                                <select name="project_type" class="selectpicker" data-width="fit">
                                    <option> Project Type </option>
                                    @if (!empty($projectType))
                                        @foreach ( $projectType as  $each)
                                            <option value="{{ $each->project_type }}">{{ $each->project_type }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group float-right">
                                <button type="submit" class="btn btn-sm btn-primary mb-3">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <table id="invoice-list" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="checkbox-column"> Record no. </th>
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
                                    <td class="checkbox-column"> 1 </td>
                                    <td><a href="https://ollyo.atlassian.net/browse/{{ $each->project_key }}" target="_blank"><span class="inv-number">#{{ $each->project_id }}</span></a></td>
                                    <td><span class="inv-amount">{{ $each->project_name }}</span></td>
                                    <td><span class="badge badge-success">{{ $each->project_key }}</span></td>
                                    <td><span class="badge badge-dark ml-2">{{ $each->project_type }}</span></td>
                                    <td>
                                        <a  href="" id="changeStatus" data-url="{{ route('project.update') }}" data-id="{{  $each->project_id }}" data-status="{{  $each->project_status_on_pmo }}" ><span class="badge badge-danger">{{ $each->project_status_on_pmo }}</span></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
