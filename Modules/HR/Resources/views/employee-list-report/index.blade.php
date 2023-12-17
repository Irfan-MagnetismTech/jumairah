@extends('layouts.backend-layout')
@section('title', 'Employee List Report')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Employee List Report
@endsection

@section('style')
    <style scoped>
        .input-group-addon {
            min-width: 120px;
        }

        .border-none>tr>td {
            border: none !important;
        }
    </style>
@endsection
@section('breadcrumb-button')
    {{-- <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('delivery-challans.index') }}"><i
            class="fas fa-database"></i></a> --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-md-12 col-lg-12 col-sm-12 my-3')

@section('content')
    @if ($formType == 'employee-list')
        {!! Form::open([
            'url' => 'hr/employee-list/report',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_type_id">Employee Type</label>
                {{Form::select('employee_type_id', $employee_types, old('employee_type_id'),['class' => 'form-control','id' => 'employee_type_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('employee_type_id')
                    <p class="text-danger">{{ $errors->first('employee_type_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="designation_id">Designation</label>
                {{Form::select('designation_id', $designations, old('designation_id'),['class' => 'form-control select2','id' => 'designation_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('designation_id')
                    <p class="text-danger">{{ $errors->first('designation_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="department_id">Department</label>
                {{Form::select('department_id', $departments, old('department_id'),['class' => 'form-control select2','id' => 'department_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="department_id">Status</label>
                <select name="status" class="form-control"
                                id="status" autocomplete="off">
                                <option value="">All</option>
                                <option value="active">Active</option>

                                @foreach ($released_types as $released_type)
                                    <option value="{{ $released_type->id }}">{{ $released_type->name }}</option>
                                @endforeach
                </select>
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date">Joining From Date</label>
                {{ Form::date(
                    'from_date',
                    old('from_date'),
                    [
                        'class' => 'form-control',
                        'id' => 'from_date',
                        'placeholder' => 'Enter from_date Here',
                    ],
                ) }}

            </div>
                @error('from_date')
                    <p class="text-danger">{{ $errors->first('from_date') }}</p>
                @enderror
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date">Joining To Date</label>
                {{ Form::date(
                    'to_date',
                    old('to_date'),
                    [
                        'class' => 'form-control',
                        'id' => 'to_date',
                        'placeholder' => 'Enter to_date Here',
                    ],
                ) }}

            </div>
            @error('to_date')
                    <p class="text-danger">{{ $errors->first('to_date') }}</p>
                @enderror
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="job_location_id">Job Location</label>
                {{Form::select('job_location_id', $jobLocations, old('job_location_id'),['class' => 'form-control select2','id' => 'job_location_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('job_location_id')
                    <p class="text-danger">{{ $errors->first('job_location_id') }}</p>
                @enderror
            </div>
        </div>

    </div>

    {{-- <hr class="bg-success"> --}}

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2" formtarget="_blank">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}
@endsection
@section('script')

<script>
    $(document).ready(function() {
       
    });

</script>

@endsection
