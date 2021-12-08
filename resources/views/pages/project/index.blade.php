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
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Find Task By</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form action="{{ route('project.list') }}">
                        <div class="row ml-3 mt-3">
                            <div class="form-group col-md-2">
                                <select name="project_type" class="selectpicker" data-width="fit">
                                    <option vlaue=""> Project Type </option>
                                    @if (!empty($projectType))
                                        @foreach ( $projectType as  $each)
                                            @if (empty($each->project_type)) continue @endif
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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ( ! empty($projects) )
                            @foreach ($projects as $each)
                                <tr>
                                    <td class="checkbox-column"> 1 </td>
                                    <td><a href="{{ route('task.list', $each->project_key) }}"><span class="inv-number">#{{ $each->project_id }}</span></a></td>
                                    <td><span class="inv-amount">{{ $each->project_name }}</span></td>
                                    <td><span class="badge badge-success">{{ $each->project_key }}</span></td>
                                    <td><span class="badge badge-dark ml-2">{{ $each->project_type }}</span></td>
                                    <td>
                                        <a  href="" id="changeStatus" data-url="{{ route('project.update') }}" data-id="{{  $each->project_id }}" data-status="{{  $each->project_status_on_pmo }}" ><span class="badge badge-danger">{{ $each->project_status_on_pmo }}</span></a>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
                                                <a class="dropdown-item action-edit" href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>Edit</a>
                                                <a class="dropdown-item action-delete" href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>Delete</a>
                                            </div>
                                        </div>
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
