@extends('boq.calculation.layout.app', ['sidebar_boq_area_floors' => $sidebar_boq_area_floors])
@section('title', 'BOQ - Calculations')
@section('project-name')
    <a href="{{ route('boq.project.calculations.index', ['project' => $project]) }}" style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    {{ $boq_area_floor->name }}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('breadcrumb-button')
    <a href="{{ route('boq.project.calculations.show', ['project' => $project, 'boq_area_floor' => $boq_area_floor]) }}" class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection

@section('content')
    <form action="" class="custom-form">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>Work type<span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Select work -->
                            <div class="col-xl-12 col-md-12">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                                    <select class="form-control" id="work_id" name="work_id" required>
                                        <option value="">Select Work</option>
                                        @foreach ($boq_works as $boq_work)
                                            <option value="{{ $boq_work->id }}" @if($boq_work->id == $work_id) selected @endif>{{ $boq_work->name }} - {{ $boq_work->short_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        @include('components.buttons.submit-button', ['label' => 'Show'])
    </form>

    <div class="mt-4 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>{{ $work ? $work->name : 'Calculations' }}<span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="mt-4 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                {{-- <tr>{{  }}</tr> --}}
                                <tr>
                                    <th> Sub-location </th>
                                    <th> No <span class="text-danger">*</span></th>
                                    <th> Length <span class="text-danger">*</span></th>
                                    <th> Breadth <span class="text-danger">*</span></th>
                                    <th> Height <span class="text-danger">*</span></th>
                                    <th> Sub-total </th>
                                    <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total:</th>
                                    <th>
                                        <div id="total" class="form-control text-right" readonly>0.00</div>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>
@endsection
