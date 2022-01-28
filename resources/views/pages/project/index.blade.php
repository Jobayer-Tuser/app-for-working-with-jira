@extends('layouts.app')
@section('title', 'Project list')

@section('breadcrumb-main', 'Project')
@section('breadcrumb-sub', 'list')

@section('content')

@push('css')
    <style>
        .selectClass{
            width: 55%;
            margin-left: 6.7rem;
        }
    </style>
@endpush

<div class="row">
    <div class="d-flex justify-content-end">
        <p  class="col-md-1 mt-2">Search : </p>
        <div style="margin-right: 1rem; " class="mb-3 col-md-2">
            <select name="project_type" class="form-control selectClass">
                <option value="">Project Type</option>
                @if ( isset($projectType) && is_object($projectType))
                    @foreach ( $projectType as $each )
                        <option value="{{ $each->project_type }}">{{ $each->project_type }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

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

                    <tbody id="projectList">

                    </tbody>
                </table>
                {{-- {{ $projects->links() }} --}}
            </div>
        </div>
    </div>
</div>

@push('script')

    <script type="text/javascript">
        $( document ).ready(function() {
            loadProject();

            $( document ).on('change', '[name="project_type"]', function(event){
                let projectType = $('[name="project_type"]').val();
                loadProject(projectType);
            });

            $( document ).on('click', '[name="changeProjectStat"]', function(event){

                event.preventDefault();
                let projectStat = $(this).data('value');
                let id = $(this).data('id');

                $.ajax({
                    url     : "{{ route('project.update.status') }}",
                    method  : "POST",
                    data    : {
                        "_token"    : "{{ csrf_token() }}",
                        projectStat : projectStat,
                        id : id
                    },
                    success: function( data ){
                        console.log(data);
                        if ( data == true ){
                            loadProject();
                        }
                    }
                })
            });


            function loadProject(project_type = null) {
                $.ajax({
                    url     : "{{ route('project.load') }}",
                    method  : "POST",
                    data    : {
                        "_token"    : "{{ csrf_token() }}",
                        projectType : project_type ,
                    },
                    success: function( data ){
                        let post = '';
                        $.each( data , function( index, value ){
                            post += `<tr>
                                    <td><input type="checkbox" name="projectID" class="form-check-input" /></td>
                                    <td><a href="https://ollyo.atlassian.net/browse/${value.project_key}" target="_blank"><span class="inv-number">#${value.project_id}</span></a></td>
                                    <td>${value.project_name }</td>
                                    <td><span class="badge bg-success">${value.project_key}</span></td>
                                    <td><span class="badge bg-dark">${value.project_type}</span></td>
                                    <td>
                                        <button name="changeProjectStat" data-id="${value.project_id}" data-value="${value.project_status_on_pmo}" type="submit" class="btn btn-sm ${ value.project_status_on_pmo == 'Tracked' ? 'btn-success': 'btn-soft-dark' }">${value.project_status_on_pmo}</button>
                                    </td>
                                </tr>`;
                        });
                        $('#projectList').html(post);
                    }
                })
            }
        });
    </script>
@endpush

@endsection
