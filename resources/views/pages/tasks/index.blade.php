@extends('layouts.app')
@section('title', 'Task List')
@section('breadcrumb-main', 'Task')
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
                    <form class="" action="{{ route('task.list', $projectKey) }}">

                        @csrf
                        <input type="hidden" name="projectKey" value="{{ $projectKey }}"/>
                        <div class="row ml-3 mt-3">
                            <div class="form-group ">
                                <select name="assignee" class="selectpicker" data-width="fit">
                                    <option vlaue="0">Assignee </option>
                                    @if (!empty($assignedPerson))
                                        @foreach ( $assignedPerson as  $each)
                                            <option value="{{ $each->assignee }}">{{ $each->assignee }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group ml-3">
                                <select name="tastState" class="selectpicker" data-width="fit">
                                    <option vlaue="0">Task Status </option>
                                    @if(!empty($tastState))
                                        @foreach ($tastState as $each)
                                            <option value="{{ $each->state_name }}">{{ $each->state_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group ml-3">
                                <select name="spintName" class="selectpicker" data-width="fit">
                                    <option vlaue="">Sprint</option>
                                    @if(!empty($sprintName))
                                        @foreach ($sprintName as $each)
                                            <option value="{{ $each->sprint_name }}">{{ $each->sprint_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4 mt-2">
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
                            <th>Project Name</th>
                            <th>Sprint Name</th>
                            <th>Assinee</th>
                            <th>Task Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ( ! empty($tasks) )
                            @foreach ($tasks as $each)
                                <tr>
                                    <td class="checkbox-column"> 1 </td>
                                    <td><span class="">{{ $each->project_name }}</span></td>
                                    <td><span class="">{{ $each->sprint_name }}</span></td>
                                    <td><span class="">{{ $each->assignee }}</span></td>
                                    <td><span class="badge badge-danger">{{ $each->task_status }}</span></td>
                                    <td><span class="inv-date">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg> {{ \Carbon\Carbon::parse($each->task_start_date)->diffForHumans() }} </span>
                                    </td>
                                    <td><span class="inv-date">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg> {{ \Carbon\Carbon::parse($each->task_end_date)->diffForHumans() }} </span>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink2">
                                                <a class="dropdown-item action-edit" href="apps_invoice-edit.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>Edit</a>
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

@push('script')
    {{-- <script type="text/javascript">
    ;(function($){
        $(document).on('change', '[name="assignee"]', function() {
            let assigneeName = $(this).val;
            console.log(assigneeName)
        });

    })(jQuery);
    </script> --}}
@endpush

@endsection
