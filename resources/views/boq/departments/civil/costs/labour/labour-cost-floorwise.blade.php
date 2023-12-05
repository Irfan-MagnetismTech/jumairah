@extends('boq.departments.civil.layout.app')

@section('project-name', $project->name)

@section('breadcrumb-title')

@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('breadcrumb-button')

@endsection

@section('content')
    <style>
        #submit-button{
            width: auto;
        }
    </style>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Area & Work type<span>&#10070;</span> </h5>
                </div>
                <form action="{{ route('boq.project.departments.civil.costs.labours.index', ['project' => $project]) }}" method="GET">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5" style="margin-bottom: 10px">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" style="background: #227447" for="work_id">Select Work<span class="text-danger">*</span></label>
                                    <select class="form-control work_id" id="work_id" name="work_id" required>
                                        <option value="">Select Work</option>
                                        @foreach ($boq_works as $work)
                                            <option value="{{ $work?->boq_work_id }}" @if ($work?->boq_work_id == request()->input('work_id')) selected @endif>{{ $work?->boqWork?->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" name="calculation_type" value="">
                            <!-- Select work -->
                            <div class="col-5">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" style="background: #227447" for="boq_floor_id">Select Area <span class="text-danger">*</span></label>
                                    <select class="form-control" id="boq_floor_id" name="boq_floor_id" required>
                                        <option value="">Select Area</option>
                                        @foreach ($boq_floors as $floor)
                                            <option value="{{ $floor?->boq_floor_id }}" @if ($floor?->boq_floor_id == request()->input('boq_floor_id')) selected @endif>{{ $floor?->boqCivilCalcProjectFloor?->boqCommonFloor?->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group input-group-sm ">
                                    <button type="submit" class="py-2 btn btn-success btn-round btn-block" id="submit-button">Show</button>
                                </div>
                            </div>


                            <input type="hidden" name="final_total" id="final_total">

                            <!-- Select sub-work -->
                            <div class="col-xl-12 col-md-12">
                                <div id="subwork"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>

    <form action="{{ route('boq.project.departments.civil.costs.labours.store', ['project' => $project]) }}" method="POST" enctype="multipart/form-data" class="custom-form">
        @csrf
        @include('boq.departments.civil.costs.labour.form')
        @include('components.buttons.submit-button', ['label' => 'Update Labour cost'])
    </form>
@endsection
