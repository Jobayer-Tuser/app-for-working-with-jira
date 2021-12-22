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
    <form action="">
        <div class="d-flex justify-content-end">
            <div class="mb-3 col-md-2">
                <select class="form-control filterVar" name="">
                    <option value="">Dev Team</option>
                    <option value="">Choice 1</option>
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <select class="form-control filterVar" name="">
                    <option value="">Project</option>
                    <option value="">Choice 1</option>
                </select>
            </div>
            <div class="mb-3 col-md-2">
                <select class="form-control filterVar" name="">
                    <option value="">Project Status</option>
                    <option value="">Choice 1</option>
                </select>
            </div>

            <div class="ml-2">
                <button class="btn btn-sm btn-primary">Show</button>
            </div>

        </div>

    </form>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <h1 class="card-title">Special title treatment</h1>
                <span class="badge bg-success">Builder</span>
                <span class="badge bg-success">Builder</span>
                <span class="badge bg-success">Builder</span>
            </div>

            <div class="px-3">
                <ul class="list-unstyled">
                    <li class="">
                        <div class="d-flex">
                            <div class="font-size-20 text-success">
                                <i class="bx bx-down-arrow-circle d-block"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate text-muted font-size-14  description">Let say something together</p>
                            </div>
                        </div>
                    </li>
                    <li class="">
                        <div class="d-flex">
                            <div class="font-size-20 text-success">
                                <i class="bx bx-down-arrow-circle d-block"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate text-muted font-size-14  description">Let say something together</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="px-5">
                <hr class="hrClass" />
            </div>

            <div class="card-body">
                <span class="badge bg-success">Builder</span>
                <span class="badge bg-success">Builder</span>
                <span class="badge bg-success">Builder</span>
            </div>

            <div class="px-3">
                <ul class="list-unstyled">
                    <li class="">
                        <div class="d-flex">
                            <div class="font-size-20 text-success">
                                <i class="bx bx-down-arrow-circle d-block"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate text-muted font-size-14  description">Let say something together</p>
                            </div>
                        </div>
                    </li>
                    <li class="">
                        <div class="d-flex">
                            <div class="font-size-20 text-success">
                                <i class="bx bx-down-arrow-circle d-block"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-truncate text-muted font-size-14  description">Let say something together</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

@endsection
