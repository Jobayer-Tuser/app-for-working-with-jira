<form id="status-update" action="{{ route('project.update') }}" method="POST">
    @csrf
    <input type="hidden" name="project_status" value="{{ $each->project_status_on_pmo }}" />
    <input type="hidden" name="project_id" value="{{ $each->project_id }}" />
    <button type="submit" class="btn btn-sm btn-success">{{ $each->project_status_on_pmo }}</button>
</form>

<td>
    <a id="changeStatus" data-url="{{ route('project.update') }}" onclick="event.preventDefault(); document.getElementById('status-update').submit();"><span class="badge badge-danger">{{ $each->project_status_on_pmo }}</span></a>
    <form id="status-update" action="{{ route('project.update') }}" method="POST" class="d-none">
        @csrf
        <input type="hidden" name="project_status" value="{{ $each->project_status_on_pmo }}" />
        <input type="hidden" name="project_id" value="{{ $each->project_id }}" />
    </form>
</td>

<div id="tableLight" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Find Task By</h4>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form action="" method="">

                        {{-- @csrf --}}
                        {{-- <input type="hidden" name="projectKey" value="{{ $projectKey }}"/> --}}
                        <div class="table">
                            <table class="table table-hover table-light mb-4">
                                <thead>
                                    <tr>
                                        <th class="text-center">Project Type</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">
                                            <div class="form-group">
                                                <select name="assignee" class="selectpicker" data-width="fit">
                                                    <option vlaue="0">Assignee </option>
                                                    @if (!empty($projectType))
                                                        @foreach ( $projectType as  $each)
                                                            @if (empty($each->project_type)) continue @endif
                                                            <option value="{{ $each->project_type }}">{{ $each->project_type }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-primary mb-3">Search</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>






@extends('layouts.app')

@section('title', 'Show Project Details')

@section('content')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
@endpush

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <table id="project_data" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            {{-- <th class="checkbox-column"> Record no. </th> --}}
                            <th>Project Name</th>
                            <th>Sprint Name</th>
                            {{-- <th>Assinee</th> --}}
                            <th>Task Status</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            {{-- <th>Actions</th> --}}

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function(){

    fill_datatable();

    function fill_datatable(filter_gender = '', filter_country = '')
    {
        var dataTable = $('#project_data').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('project.show') }}",
                // data:{filter_gender:filter_gender, filter_country:filter_country}

            },
            columns: [
                {
                    data:'project_id',
                    name:'project_id'
                },
                {
                    data:'project_key',
                    name:'project_key'
                },
                {
                    data:'project_name',
                    name:'project_name'
                },
                {
                    data:'project_type',
                    name:'project_type'
                },
                {
                    data:'project_status_on_pmo',
                    name:'project_status_on_pmo'
                }
            ]
        });
    }

    $('#filter').click(function(){
        var filter_gender = $('#filter_gender').val();
        var filter_country = $('#filter_country').val();

        if(filter_gender != '' &&  filter_gender != '')
        {
            $('#customer_data').DataTable().destroy();
            fill_datatable(filter_gender, filter_country);
        }
        else
        {
            alert('Select Both filter option');
        }
    });

    $('#reset').click(function(){
        $('#filter_gender').val('');
        $('#filter_country').val('');
        $('#customer_data').DataTable().destroy();
        fill_datatable();
    });

    });
</script>
@endpush



@push('script')
<script>
    (function($){

        //Ajax function for project status change
        $(document).on('click', '#changeStatus', function(event){
            event.preventDefault();
            let id     = $('#changeStatus').data('id');
            let url    = $('#changeStatus').data('url');
            let status = $('#changeStatus').data('status');
            $.ajax({
                url    : url,
                type   : "POST",
                data   : {
                    id : id,
                    status: status,
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response){
                    console.log(response)
                }
            })
        })

        //ajax call for filter

    })(jQuery);
</script>
@endpush
@endsection


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
                            <form class="" method="POST" action="{{ route('task.sync') }}">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary mb-3">Sync</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <form class="" action="{{ route('task.list', $projectKey) }}">

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




@if ( ! empty($projects) )
                            @foreach ($projects as $each)
                                <tr>
                                    <td><input type="checkbox" name="projectID" class="form-check-input" /></td>
                                    <td><a href="https://ollyo.atlassian.net/browse/{{ $each->project_key }}" target="_blank"><span class="inv-number">#{{ $each->project_id }}</span></a></td>
                                    <td>{{ $each->project_name }}</td>
                                    <td><span class="badge bg-success">{{ $each->project_key }}</span></td>
                                    <td><span class="badge bg-dark">{{ $each->project_type }}</span></td>
                                    <td>
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch1" switch="none" checked />
                                            <label for="square-switch1" data-on-label="On"
                                                data-off-label="Off"></label>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-soft-dark">{{ $each->project_status_on_pmo }}</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
