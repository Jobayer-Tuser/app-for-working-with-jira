@extends('layouts.app')
@section('title', 'Task list')

@section('breadcrumb-main', 'Task')
@section('breadcrumb-sub', 'list')

@section('content')

@push('css')
    <style>
        .filterVar{
            width: 60% !important;
        }
        .description {
            margin-bottom: 5px !important;
            margin-left: 5px !important;
        }
        .hrClass{
            border-top: 1px solid rgb(5, 4, 7);
            width: 80%;
            left: 20%;
            margin: 0px;
        }
    </style>
@endpush
<div class="row">
    <form action="POST" id="taskFilterForm" action="{{ route('task.load') }}">
        <div class="d-flex justify-content-end">
            <div class="mb-3 col-md-2">
                <select class="form-control filterVar" name="group_name">
                    <option value="">Chose Team</option>
                    @if( ! empty( $groups ) )
                        @foreach ( $groups as $group )
                            <option value="{{ $group->name }}">{{ $group->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <select class="form-control filterVar" name="project_name">
                    <option value="">Project</option>
                    @if( ! empty( $projects ) )
                        @foreach ( $projects as $project )
                            <option value="{{ $project->project_name }}">{{ $project->project_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <select class="form-control filterVar" name="project_status">
                    <option value="">Project Status</option>
                    @if( ! empty( $taskStates ) )
                        @foreach ( $taskStates as $taskState )
                            <option value="{{ $taskState->state_name }}">{{ $taskState->state_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="ml-2">
                <button type="submit" class="btn btn-sm btn-primary">Show</button>
            </div>

        </div>

    </form>
</div>

<div class="row">
    <div class="col-md-12" id="loadTask">

    </div>
</div>


@push('script')

    <script type="text/javascript">

        $( document ).ready(function() {

            class RenderTaskList {

                constructor( param ){
                    this.data = param;
                }

                renderEvent ( ) {
                    $('#loadTask').html( this.template() );
                }

                template() {
                    let mainMarkup = '';

                    this.data.map((value, key)=>{
                            mainMarkup += `<div class="card">
                                <h1 class="card-title ml-5 mt-3">${ value.name }</h1>`;
                                value.details.map((value2, key)=>{

                                            mainMarkup +=`
                                            <div class="card-body">
                                                <span class="badge bg-dark"> ${ value2.title } </span> <span class="badge bg-dark"> ${value2.sprint} </span>
                                            </div>

                                            <div class="px-3">
                                                <ul class="list-unstyled">`;
                                                    value2.task.map(( value3, key )=>{
                                                        mainMarkup += `<li class="">
                                                            <div class="d-flex">
                                                                <div class="font-size-20 text-dark">
                                                                    <i class="bx bx-down-arrow-circle d-block"></i>
                                                                    </div>
                                                                <div class="flex-grow-1 overflow-hidden">
                                                                    <p class="text-truncate text-muted font-size-14  description"> ${ value3 }</p>
                                                                </div>
                                                                </div>
                                                        </li>`
                                                    });
                                    mainMarkup +=`</ul>
                                        </div>
                                        <div class="px-5">
                                            <hr class="hrClass" />
                                        </div>`

                                    })
                                    mainMarkup +=`</div>`;
                                });
                                return mainMarkup;
                    if ( this.data == 'object' && this.data > 0 ){
                    }
                }
            }

            loadTask();

            function loadTask( group_name = null, project_name = null, project_status = null ) {
                $.ajax({
                    url     : "{{ route('task.load') }}",
                    method  : "POST",
                    data    : {
                        _token          : "{{ csrf_token() }}",
                        group_name      : group_name,
                        project_name    : project_name,
                        project_status  : project_status,
                    },
                    success: function( data ){
                        const app = new RenderTaskList(data)
			            app.renderEvent();
                    }
                })
            }

            $( document ).on('submit', '#taskFilterForm', function( event ) {
                event.preventDefault();

                let groupName       = $('[name="group_name"]').val();
                let projectName     = $('[name="project_name"]').val();
                let projectStatus   = $('[name="project_status"]').val();

                loadTask( groupName, projectName, projectStatus );
            });
        });
    </script>
@endpush

@endsection
