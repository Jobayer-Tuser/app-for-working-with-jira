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


