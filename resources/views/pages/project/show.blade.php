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
                data:{filter_gender:filter_gender, filter_country:filter_country}
            },
            columns: [
                {
                    data:'project_key',
                    name:'project_key'
                },
                {
                    data:'project_name',
                    name:'project_name'
                },
                {
                    data:'project_id',
                    name:'project_id'
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

@endsection

