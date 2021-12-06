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
