@extends('layouts.backend-layout')
@section('title', 'Create Employee')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Employee
@endsection

@section('style')
    <style scoped>
        .input-group-addon {
            min-width: 120px;
        }

        :root {
            --m1-tabs-bg: #e1e1e1;
            --m1-tab-text: #888;
            --m1-tab-bg: #f7f7f7;
            --m1-tab-hover-text: #75C3D8;
            --m1-tab-hover-bg: #fff;
            --m1-tab-active-text: #fff;
            --m1-tab-active-bg: #75C3D8;

            --m2-tabs-bg: #e1e1e1;
            --m2-tab-text: #75C3D8;
            --m2-tab-bg: #f7f7f7;
            --m2-tab-hover-text: #888;
            --m2-tab-hover-bg: transparent;
            --m2-tab-active-text: #888;
            --m2-tab-active-bg: #fff;

            --m3-border: #e1e1e1;
            --m3-tabs-bg: #fff;
            --m3-tab-text: #75C3D8;
            --m3-tab-bg: transparent;
            --m3-tab-hover-text: #888;
            --m3-tab-hover-bg: transparent;
            --m3-tab-active-text: #75C3D8;
            --m3-tab-active-bg: transparent;

            --m4-bg-color: #eee;
            --m4-border: #aaa;
            --m4-tab-text: #75C3D8;
            --m4-tab-hover-text: #888;

            --m5-tabs-bg: #e1e1e1;
            --m5-border: #aaa;
            --m5-tab-text: #888;
            --m5-tab-bg: #e1e1e1;
            --m5-tab-hover-text: #75C3D8;
            --m5-tab-hover-bg: #e1e1e1;

            --m6-tabs-bg: transparent;
            --m6-tab-text: #888;
            --m6-tab-bg: transparent;
            --m6-tab-hover-text: #75C3D8;
            --m6-tab-hover-bg: transparent;
        }

        section {
            padding-bottom: 20px;
        }

        h1 {
            font-size: 1.8em;
            text-align: center;
            text-transform: uppercase;
        }

        .tab-content .tab-pane {
            margin: 0;
            padding: 0.2em 0;
            color: rgba(40, 44, 42, 0.05);
            font-weight: 900;
            font-size: 4em;
            line-height: 1;
            text-align: center;
        }

        #model_3 .tabs-container {
            background: var(--m3-tabs-bg);
        }

        #model_3 .nav-tabs {
            border: 0;
            text-align: center;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: -moz-flex;
            display: -ms-flex;
            display: flex;
            -ms-box-orient: horizontal;
            -ms-box-pack: center;
            -webkit-flex-flow: row wrap;
            -moz-flex-flow: row wrap;
            -ms-flex-flow: row wrap;
            flex-flow: row wrap;
            -webkit-justify-content: center;
            -moz-justify-content: center;
            -ms-justify-content: center;
            justify-content: center;
        }

        #model_3 .nav .nav-item {
            position: relative;
            z-index: 1;
            display: block;
            margin: 0;
            text-align: center;
            -webkit-flex: 1;
            -moz-flex: 1;
            -ms-flex: 1;
            flex: 1;
        }

        #model_3 .nav .nav-link {
            border: 0;
            border-radius: 0;
            padding: 0.5em 0;
            border-left: 1px solid var(--m3-border);
            -webkit-transition: color 0.2s;
            transition: color 0.2s;
            position: relative;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            line-height: 2.5;
            background-color: var(--m3-tab-bg);
            color: var(--m3-tab-text);
            outline: none;
        }

        #model_3 .nav .nav-link::before {
            content: '';
            display: block;
            position: absolute;
            z-index: 10;
            bottom: 6px;
            height: 6px;
            left: 0;
            width: 100%;
            background: var(--m3-tabs-bg);
            -webkit-transition: -webkit-transform 0.3s;
            transition: transform 0.3s;
            -webkit-transform: translate3d(0, 150%, 0);
            transform: translate3d(0, 150%, 0);
        }

        #model_3 .nav .nav-item:last-child a {
            border-right: 1px solid var(--m3-border);
        }

        #model_3 .nav .nav-link:hover {
            background-color: var(--m3-tab-hover-bg);
            color: var(--m3-tab-hover-text);
        }

        #model_3 .nav .nav-link.active,
        #model_3 .nav .nav-link.active:hover {
            background: var(--m3-tab-active-bg);
            color: var(--m3-tab-active-text);
        }

        #model_3 .nav .nav-link.active::before {
            background: var(--m3-tab-active-text);
        }

        #model_3 .nav i {
            display: inline-block;
            margin: 0 0.4em 0 0;
            vertical-align: middle;
            text-transform: none;
            font-weight: normal;
            font-variant: normal;
            font-size: 1.3em;
            line-height: 1;
            -webkit-backface-visibility: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .sub-title {
            margin-bottom: 0px !important;
        }

        .tab-headings {
            margin-bottom: 0px !important;
            margin-top: 20px;
        }

        a.disabled {
            pointer-events: none;
            /* Disable pointer events */
            cursor: default;
            /* Set default cursor */
            color: gray;
            /* Set disabled color */
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('employee-masters.index') }}">
        <i class="fas fa-database"></i>
    </a>
@endsection
@section('sub-title')
    Marked are required.
@endsection
@section('content-grid', 'col-md-12 col-lg-12 ')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/employee-masters',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/employee-masters/$employee->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif


    <div id="main" class="container-fluid">
        <section id="model_3">
            <div class="tabs-container">
                <ul class="nav nav-tabs container" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#personal" role="tab"
                            aria-controls="home" aria-selected="true"><i class="fa fa-user"></i>Personal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="details-tab" data-toggle="tab" href="#details" role="tab"
                            aria-controls="profile" aria-selected="false"><i class="fa fa-address-card"></i>Details</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="address-tab" data-toggle="tab" href="#address" role="tab"
                            aria-controls="contact" aria-selected="false"><i class="fa fa-envelope"></i>Address</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="bankinfo-tab" data-toggle="tab" href="#bankinfo" role="tab"
                            aria-controls="bankinfo" aria-selected="false"><i class="fa fa-envelope"></i>Bank Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="family-tab" data-toggle="tab" href="#family" role="tab"
                            aria-controls="family" aria-selected="false"><i class="fa fa-envelope"></i>Family</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="nominee-tab" data-toggle="tab" href="#nominee" role="tab"
                            aria-controls="nominee" aria-selected="false"><i class="fa fa-envelope"></i>Nominee</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="education-tab" data-toggle="tab" href="#education" role="tab"
                            aria-controls="education" aria-selected="false"><i class="fa fa-envelope"></i>Education</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="experience-tab" data-toggle="tab" href="#experience" role="tab"
                            aria-controls="experience" aria-selected="false"><i class="fa fa-envelope"></i>Experience</a>
                    </li>

                </ul>
            </div>
            <input type="hidden" name="emp_id" id="emp_id" value="{{ !empty($employee) ? $employee->id : '' }}">
            <div class="tab-content container" id="myTabContent">
                <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="home-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Personal Information</h1>
                    </div>
                    <div class="row p-3 personal-block">
                        @if ($formType != 'create')
                            <div class="col-12">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="emp_code">Employee Code/ID <span
                                            class="text-danger">*</span></label>
                                    {{ Form::text('emp_code', !empty($employee?->emp_code) ? $employee?->emp_code : '', [
                                        'class' => 'form-control required-field',
                                        'id' => 'emp_code',
                                        'placeholder' => 'Enter Employee Code Here',
                                        'readonly',
                                    ]) }}
                                    @error('emp_code')
                                        <p class="text-danger">{{ $errors->first('emp_code') }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="emp_name">Employee Name <span
                                        class="text-danger">*</span></label>
                                {{ Form::text(
                                    'emp_name',
                                    old('emp_name') ? old('emp_name') : (!empty($employee->emp_name) ? $employee->emp_name : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'emp_name',
                                        'placeholder' => 'Enter Employee Name Here',
                                        'required',
                                    ],
                                ) }}
                                @error('emp_name')
                                    <p class="text-danger">{{ $errors->first('emp_name') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="emp_name_bangla">Employee Name Bangla </label>
                                {{ Form::text(
                                    'emp_name_bangla',
                                    old('emp_name_bangla')
                                        ? old('emp_name_bangla')
                                        : (!empty($employee->emp_name_bangla)
                                            ? $employee->emp_name_bangla
                                            : null),
                                    ['class' => 'form-control', 'id' => 'emp_name_bangla', 'placeholder' => 'Enter Employee Bangla Name Here'],
                                ) }}
                            </div>
                        </div>


                        <div class="col-md-4">

                            @if (!empty($employee->emp_img_url))
                                <img src="/emp_img/{{ $employee->emp_img_url }}" alt="" width="100px"
                                    height="100px" style="float: left !important; border-radious:5px; margin:13px 0;"
                                    id="emp_img_preview">
                            @else
                                <img src="" alt="" width="100px"
                                height="100px" style="float: left !important; border-radious:5px; margin:13px 0;"
                                id="emp_img_preview">
                            @endif
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="emp_name_bangla">Empployee Image </label>
                                {{ Form::file('emp_img', ['class' => 'form-control from-control-sm', 'id' => 'emp_img']) }}
                            </div>
                        </div>

                        <div class="col-12"></div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="job_location_id">Job Location</label>
                                {{ Form::select(
                                    'job_location_id',
                                    $jobLocations,
                                    old('job_location_id') ? old('job_location_id') : (!empty($employee->job_location_id) ? $employee->job_location_id : null),
                                    [
                                        'class' => 'form-control',
                                        'id' => 'job_location_id',
                                        'placeholder' => 'Select Job Location',
                                    ],
                                ) }}
                                @error('job_location_id')
                                    <p class="text-danger">{{ $errors->first('job_location_id') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="department_id">Department <span
                                        class="text-danger">*</span></label>
                                {{ Form::select(
                                    'department_id',
                                    $department,
                                    old('department_id') ? old('department_id') : (!empty($employee->department_id) ? $employee->department_id : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'department_id',
                                        'placeholder' => 'Select department',
                                        'required',
                                    ],
                                ) }}
                                @error('department_id')
                                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="section_id"> Section </label>
                                {{ Form::select(
                                    'section_id',
                                    $section,
                                    old('section_id') ? old('section_id') : (!empty($employee->section_id) ? $employee->section_id : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'section_id',
                                        'placeholder' => 'Select Section',
                                    ],
                                ) }}
                                @error('section_id')
                                    <p class="text-danger">{{ $errors->first('section_id') }}</p>
                                @enderror
                            </div>

                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="sub_section_id">Sub Section </label>
                                {{ Form::select(
                                    'sub_section_id',
                                    $sub_section,
                                    old('sub_section_id')
                                        ? old('sub_section_id')
                                        : (!empty($employee->sub_section_id)
                                            ? $employee->sub_section_id
                                            : null),
                                    ['class' => 'form-control select2', 'id' => 'sub_section_id', 'placeholder' => 'Select Sub Section'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="designation_id">Designation <span
                                        class="text-danger">*</span></label>
                                {{ Form::select(
                                    'designation_id',
                                    $designation,
                                    old('designation_id')
                                        ? old('designation_id')
                                        : (!empty($employee->designation_id)
                                            ? $employee->designation_id
                                            : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'designation_id',
                                        'placeholder' => 'Select Designation',
                                        'required',
                                    ],
                                ) }}
                            </div>
                        </div>

                        {{-- <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="unit_id">Unit</label>
                                {{ Form::select(
                                    'unit_id',
                                    $unit,
                                    old('unit_id') ? old('unit_id') : (!empty($employee->unit_id) ? $employee->unit_id : null),
                                    ['class' => 'form-control select2', 'id' => 'unit_id', 'placeholder' => 'Select Unit'],
                                ) }}
                                @error('unit_id')
                                    <p class="text-danger">{{ $errors->first('unit_id') }}</p>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="floor_id">Floor</label>
                                {{ Form::select(
                                    'floor_id',
                                    $floor,
                                    old('floor_id') ? old('floor_id') : (!empty($employee->floor_id) ? $employee->floor_id : null),
                                    ['class' => 'form-control select2', 'id' => 'floor_id', 'placeholder' => 'Select Floor'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="line_id">Line</label>
                                {{ Form::select(
                                    'line_id',
                                    $line,
                                    old('line_id') ? old('line_id') : (!empty($employee->line_id) ? $employee->line_id : null),
                                    ['class' => 'form-control select2', 'id' => 'line_id', 'placeholder' => 'Select Line'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="birth_date">DOB </label>
                                {{ Form::date(
                                    'birth_date',
                                    old('birth_date') ? old('birth_date') : (!empty($employee->birth_date) ? $employee->birth_date : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'birth_date',
                                        'placeholder' => 'Enter Birth Date Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="join_date">Join Date </label>
                                {{ Form::date(
                                    'join_date',
                                    old('join_date') ? old('join_date') : (!empty($employee->join_date) ? $employee->join_date : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'join_date',
                                        'placeholder' => 'Enter Join Date Here',
                                    ],
                                ) }}
                                @error('join_date')
                                    <p class="text-danger">{{ $errors->first('join_date') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="increment_date">Increment Date</label>
                                {{ Form::date(
                                    'increment_date',
                                    old('increment_date')
                                        ? old('increment_date')
                                        : (!empty($employee->increment_date)
                                            ? $employee->increment_date
                                            : null),
                                    ['class' => 'form-control', 'id' => 'increment_date', 'placeholder' => 'Enter Increment Date Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="promotion_date">Promotion Date</label>
                                {{ Form::date(
                                    'promotion_date',
                                    old('promotion_date')
                                        ? old('promotion_date')
                                        : (!empty($employee->promotion_date)
                                            ? $employee->promotion_date
                                            : null),
                                    ['class' => 'form-control', 'id' => 'promotion_date', 'placeholder' => 'Enter Promotion Date Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="confirm_date">Confirmation Date</label>
                                {{ Form::date(
                                    'confirm_date',
                                    old('confirm_date') ? old('confirm_date') : (!empty($employee->confirm_date) ? $employee->confirm_date : null),
                                    ['class' => 'form-control', 'id' => 'confirm_date', 'placeholder' => 'Enter Confirmation Date Here'],
                                ) }}
                                @error('confirm_date')
                                    <p class="text-danger">{{ $errors->first('confirm_date') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="employee_type_id">Employee Type <span
                                        class="text-danger">*</span></label>
                                {{ Form::select(
                                    'employee_type_id',
                                    $employeeType,
                                    old('employee_type_id')
                                        ? old('employee_type_id')
                                        : (!empty($employee->employee_type_id)
                                            ? $employee->employee_type_id
                                            : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'employee_type_id',
                                        'placeholder' => 'Select Employee Type',
                                        'required',
                                    ],
                                ) }}
                                @error('employee_type_id')
                                    <p class="text-danger">{{ $errors->first('employee_type_id') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="shift_id">Shift <span
                                        class="text-danger">*</span></label>
                                {{ Form::select(
                                    'shift_id',
                                    $shift,
                                    old('shift_id') ? old('shift_id') : (!empty($employee->shift_id) ? $employee->shift_id : null),
                                    ['class' => 'form-control select2 required-field', 'id' => 'shift_id', 'placeholder' => 'Select Shift', 'required'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="gender_id">Gender</label>
                                {{ Form::select(
                                    'gender_id',
                                    $gender,
                                    old('gender_id') ? old('gender_id') : (!empty($employee->gender_id) ? $employee->gender_id : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'gender_id',
                                        'placeholder' => 'Select Gender',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="religion_id">Religion </label>
                                {{ Form::select(
                                    'religion_id',
                                    $religion,
                                    old('religion_id') ? old('religion_id') : (!empty($employee->religion_id) ? $employee->religion_id : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'religion_id',
                                        'placeholder' => 'Select Relgion',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="bllod_group">Blood Group </label>
                                {{ Form::select(
                                    'bllod_group',
                                    [
                                        'A+' => 'A+',
                                        'B+' => 'B+',
                                        'O+' => 'O+',
                                        'AB+' => 'AB+',
                                        'A-' => 'A-',
                                        'B-' => 'B-',
                                        'O-' => 'O-',
                                        'AB-' => 'AB-',
                                    ],
                                    old('bllod_group') ? old('bllod_group') : (!empty($employee->bllod_group) ? $employee->bllod_group : null),
                                    ['class' => 'form-control select2', 'id' => 'bllod_group', 'placeholder' => 'Select Blood Group'],
                                ) }}
                                @error('bllod_group')
                                    <p class="text-danger">{{ $errors->first('bllod_group') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nid_no">NID </label>
                                {{ Form::text(
                                    'nid_no',
                                    old('nid_no') ? old('nid_no') : (!empty($employee->nid_no) ? $employee->nid_no : null),
                                    ['class' => 'form-control required-field', 'id' => 'nid_no', 'placeholder' => 'Enter NID Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon">Chairman Certificate No</label>
                                {{ Form::text(
                                    'employee_detail[chairman_certificate_no]',
                                    old('employee_detail[chairman_certificate_no]')
                                        ? old('employee_detail[chairman_certificate_no]')
                                        : (!empty($employee->employee_detail->chairman_certificate_no)
                                            ? $employee->employee_detail->chairman_certificate_no
                                            : null),
                                    ['class' => 'form-control', 'id' => 'chairman_certificate_no', 'placeholder' => 'Enter Chairman Certificate No.'],
                                ) }}
                                @error('chairman_certificate_no')
                                    <p class="text-danger">{{ $errors->first('chairman_certificate_no') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="fingerprint_device_id">Fingerprint Device </label>
                                {{ Form::select(
                                    'fingerprint_device_id',
                                    $fingerprintDevices,
                                    old('fingerprint_device_id') ? old('fingerprint_device_id') : (!empty($employee->fingerprint_device_id) ? $employee->fingerprint_device_id : null),
                                    ['class' => 'form-control', 'id' => 'fingerprint_device_id', 'placeholder' => 'Select Device'],
                                ) }}
                                @error('fingerprint_device_id')
                                    <p class="text-danger">{{ $errors->first('fingerprint_device_id') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">

                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="finger_id">Finger ID </label>
                                {{ Form::text(
                                    'finger_id',
                                    old('finger_id') ? old('finger_id') : (!empty($employee->finger_id) ? $employee->finger_id : null),
                                    ['class' => 'form-control', 'id' => 'finger_id', 'placeholder' => 'Enter Finger ID Here'],
                                ) }}
                            </div>
                            <p style="font-size: 12px" class="text-danger" id="finger_id_live_error"></p>
                            @error('finger_id')
                                <p class="text-danger">{{ $errors->first('finger_id') }}</p>
                            @enderror

                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="phone_1">Phone Number 1</label>
                                {{ Form::text(
                                    'phone_1',
                                    old('phone_1') ? old('phone_1') : (!empty($employee->phone_1) ? $employee->phone_1 : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'phone_1',
                                        'placeholder' => 'Enter Phone Number Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="phone_2">Phone Number 2</label>
                                {{ Form::text(
                                    'phone_2',
                                    old('phone_2') ? old('phone_2') : (!empty($employee->phone_2) ? $employee->phone_2 : null),
                                    ['class' => 'form-control ', 'id' => 'phone_2', 'placeholder' => 'Enter Phone Number 2'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="email">Email</label>
                                {{ Form::text('email', old('email') ? old('email') : (!empty($employee->email) ? $employee->email : null), [
                                    'class' => 'form-control',
                                    'id' => 'email',
                                    'placeholder' => 'Enter Employee Email Here',
                                ]) }}
                            </div>
                        </div>



                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="skill">Skill</label>
                                {{ Form::text('skill', old('skill') ? old('skill') : (!empty($employee->skill) ? $employee->skill : null), [
                                    'class' => 'form-control',
                                    'id' => 'skill',
                                    'placeholder' => 'Enter Employee Skills Here',
                                ]) }}
                            </div>
                        </div>

                        {{-- <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_active">Active <span
                                        class="text-danger">*</span></label>
                                @if (old('is_active'))
                                    <input type="checkbox" name="is_active" value="1" id="is_active"
                                        class="employee-checkboxes" {{ old('is_active') == 1 ? 'checked' : '' }}>
                                @elseif (isset($employee) && ($employee->is_active == 1 || $employee->is_active == 0))
                                    <input type="checkbox" name="is_active" value="1" id="is_active"
                                        class="employee-checkboxes" {{ $employee->is_active == 1 ? 'checked' : '' }}>
                                @else
                                    <input type="checkbox" name="is_active" value="1" id="is_active"
                                        class="employee-checkboxes"checked>
                                @endif
                            </div>
                        </div> --}}


                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="is_active">Status <span
                                    class="text-danger">*</span></label>
                                {{ Form::select(
                                    'is_active',
                                    [
                                        '1' => 'active',
                                        '0' => 'inactive',
                                    ],
                                    old('is_active') ? old('is_active') : (!empty($employee) ? $employee->is_active :1),
                                    ['class' => 'form-control', 'id' => 'is_active', 'required', 'placeholder' => 'Select Status',
                                ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_ot_allow">OT </label>
                                {{ Form::checkbox('is_ot_allow', 0, old('is_ot_allow') ? true : (!empty($employee->is_ot_allow) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_ot_allow']) }}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_bonus">Bonus</label>
                                {{ Form::checkbox('is_bonus', 0, old('is_bonus') ? true : (!empty($employee->is_bonus) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_bonus']) }}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_holiday_allow">Holiday</label>
                                {{ Form::checkbox('is_holiday_allow', 0, old('is_holiday_allow') ? true : (!empty($employee->is_holiday_allow) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_holiday_allow']) }}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_night_allow">Night Shift</label>
                                {{ Form::checkbox('is_night_allow', 0, old('is_night_allow') ? true : (!empty($employee->is_night_allow) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_night_allow']) }}
                            </div>
                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Emplpoyee Details</h1>
                    </div>
                    <div class="row p-3 detail-block">
                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nick_name">Nick Name </label>
                                {{ Form::text(
                                    'employee_detail[nick_name]',
                                    old('employee_detail[nick_name]')
                                        ? old('employee_detail[nick_name]')
                                        : (!empty($employee->employee_detail->nick_name)
                                            ? $employee->employee_detail->nick_name
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nick_name', 'placeholder' => 'Enter Employee Nick Name Here'],
                                ) }}
                                @error('nick_name')
                                    <p class="text-danger">{{ $errors->first('nick_name') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="passport_no">Passport No </label>
                                {{ Form::text(
                                    'employee_detail[passport_no]',
                                    old('employee_detail[passport_no]')
                                        ? old('employee_detail[passport_no]')
                                        : (!empty($employee->employee_detail->passport_no)
                                            ? $employee->employee_detail->passport_no
                                            : null),
                                    ['class' => 'form-control', 'id' => 'passport_no', 'placeholder' => 'Enter Passport No. Here'],
                                ) }}
                                @error('passport_no')
                                    <p class="text-danger">{{ $errors->first('passport_no') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="birth_certificate">Birth Certificate </label>
                                {{ Form::text(
                                    'employee_detail[birth_certificate]',
                                    old('employee_detail[birth_certificate]')
                                        ? old('employee_detail[birth_certificate]')
                                        : (!empty($employee->employee_detail->birth_certificate)
                                            ? $employee->employee_detail->birth_certificate
                                            : null),
                                    ['class' => 'form-control', 'id' => 'birth_certificate', 'placeholder' => 'Enter Birth Certificate Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="week_day">Week Day </label>
                                {{ Form::select(
                                    'employee_detail[week_day]',
                                    [
                                        'Friday' => 'Friday',
                                        'Saturday' => 'Saturday',
                                        'Sunday' => 'Sunday',
                                        'Monday' => 'Monday',
                                        'Tuesday' => 'Tuesday',
                                        'Wednesday' => 'Wednesday',
                                        'Thursday' => 'Thursday',
                                    ],
                                    old('employee_detail[week_day]')
                                        ? old('employee_detail[week_day]')
                                        : (!empty($employee->employee_detail->week_day)
                                            ? $employee->employee_detail->week_day
                                            : null),
                                    ['class' => 'form-control select2 required-field', 'id' => 'week_day', 'placeholder' => 'Select Weekend'],
                                ) }}
                                @error('week_day')
                                    <p class="text-danger">{{ $errors->first('week_day') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="tin_no">Tin No </label>
                                {{ Form::text(
                                    'employee_detail[tin_no]',
                                    old('employee_detail[tin_no]')
                                        ? old('employee_detail[tin_no]')
                                        : (!empty($employee->employee_detail->tin_no)
                                            ? $employee->employee_detail->tin_no
                                            : null),
                                    ['class' => 'form-control', 'id' => 'tin_no', 'placeholder' => 'Enter TIN no Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="natinality">Nationality</label>
                                {{ Form::text(
                                    'employee_detail[natinality]',
                                    old('employee_detail[natinality]')
                                        ? old('employee_detail[natinality]')
                                        : (!empty($employee->employee_detail->natinality)
                                            ? $employee->employee_detail->natinality
                                            : null),
                                    ['class' => 'form-control required-field', 'id' => 'natinality', 'placeholder' => 'Enter Nationality Here'],
                                ) }}
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="caste">Caste</label>
                                {{ Form::text(
                                    'employee_detail[caste]',
                                    old('employee_detail[caste]')
                                        ? old('employee_detail[caste]')
                                        : (!empty($employee->employee_detail->caste)
                                            ? $employee->employee_detail->caste
                                            : null),
                                    ['class' => 'form-control', 'id' => 'caste', 'placeholder' => 'Enter Caste Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="identification_sign">Identification Sign</label>
                                {{ Form::text(
                                    'employee_detail[identification_sign]',
                                    old('employee_detail[identification_sign]')
                                        ? old('employee_detail[identification_sign]')
                                        : (!empty($employee->employee_detail->identification_sign)
                                            ? $employee->employee_detail->identification_sign
                                            : null),
                                    ['class' => 'form-control', 'id' => 'identification_sign', 'placeholder' => 'Enter Identification Sign Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="height">Height</label>
                                {{ Form::text(
                                    'employee_detail[height]',
                                    old('employee_detail[height]')
                                        ? old('employee_detail[height]')
                                        : (!empty($employee->employee_detail->height)
                                            ? $employee->employee_detail->height
                                            : null),
                                    ['class' => 'form-control', 'id' => 'height', 'placeholder' => 'Enter Employee Height Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="weight">Weight</label>
                                {{ Form::text(
                                    'employee_detail[weight]',
                                    old('employee_detail[weight]')
                                        ? old('employee_detail[weight]')
                                        : (!empty($employee->employee_detail->weight)
                                            ? $employee->employee_detail->weight
                                            : null),
                                    ['class' => 'form-control', 'id' => 'weight', 'placeholder' => 'Enter Employee Weight Here'],
                                ) }}
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="vaccinated">Vaccinated </label>
                                {{ Form::select(
                                    'employee_detail[vaccinated]',
                                    [
                                        'No' => 'No',
                                        'First Dose' => 'First Dose',
                                        'Second Dose' => 'Second Dose',
                                        'Third Dose' => 'Third Dose',
                                    ],
                                    old('employee_detail[vaccinated]')
                                        ? old('employee_detail[vaccinated]')
                                        : (!empty($employee->employee_detail->vaccinated)
                                            ? $employee->employee_detail->vaccinated
                                            : 'No'),
                                    ['class' => 'form-control select2 required-field', 'id' => 'vaccinated', 'placeholder' => 'Select Vaccination'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="emergency_contact_name">Emergency Contact
                                    Name </label>
                                {{ Form::text(
                                    'employee_detail[emergency_contact_name]',
                                    old('employee_detail[emergency_contact_name]')
                                        ? old('employee_detail[emergency_contact_name]')
                                        : (!empty($employee->employee_detail->emergency_contact_name)
                                            ? $employee->employee_detail->emergency_contact_name
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'emergency_contact_name',
                                        'placeholder' => 'Enter Emergency Contact Name Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="emergency_contact_number">Emergency Contact Number
                                </label>
                                {{ Form::text(
                                    'employee_detail[emergency_contact_number]',
                                    old('employee_detail[emergency_contact_number]')
                                        ? old('employee_detail[emergency_contact_number]')
                                        : (!empty($employee->employee_detail->emergency_contact_number)
                                            ? $employee->employee_detail->emergency_contact_number
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'emergency_contact_number',
                                        'placeholder' => 'Enter Emergency Contact Number Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="grade_id">Grade</label>
                                {{ Form::select(
                                    'employee_detail[grade_id]',
                                    $grade,
                                    old('employee_detail[grade_id]')
                                        ? old('employee_detail[grade_id]')
                                        : (!empty($employee->employee_detail->grade_id)
                                            ? $employee->employee_detail->grade_id
                                            : null),
                                    ['class' => 'form-control select2 required-field', 'id' => 'grade_id', 'placeholder' => 'Select grade'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_allow_pf">Allow PF</label>
                                {{ Form::checkbox('employee_detail[is_allow_pf]', 0, old('employee_detail[is_allow_pf]') ? true : (!empty($employee->employee_detail->is_allow_pf) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_allow_pf']) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="pf_date">PF Date</label>
                                {{ Form::date(
                                    'employee_detail[pf_date]',
                                    old('employee_detail[pf_date]')
                                        ? old('employee_detail[pf_date]')
                                        : (!empty($employee->employee_detail->pf_date)
                                            ? $employee->employee_detail->pf_date
                                            : null),
                                    ['class' => 'form-control', 'id' => 'pf_date', 'placeholder' => 'Enter Employee PF Date Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_police_verify">Police Verified</label>
                                {{ Form::checkbox('employee_detail[is_police_verify]', 0, old('employee_detail[is_police_verify]') ? true : (!empty($employee->employee_detail->is_police_verify) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_police_verify']) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_using_house">House Using</label>
                                {{ Form::checkbox('employee_detail[is_using_house]', 0, old('employee_detail[is_using_house]') ? true : (!empty($employee->employee_detail->is_using_house) ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_using_house']) }}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Employee Address</h1>
                    </div>
                    <div class="row p-3 address-block">
                        <div class="col-12 text-left mb-3"
                            style="font-size:medium; color:#75C3D8; border-bottom: 1px solid #75C3D8">
                            <span class="">Permenant Address</span>
                        </div>
                        <input type="hidden" id="address_type_0" name="employee_address[0][address_type]"
                            value="permanent" />
                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="division_id_0">Division</label>

                                {{ Form::select(
                                    'employee_address[0][division_id]',
                                    $division,
                                    old('employee_address[0][division_id]')
                                        ? old('employee_address[0][division_id]')
                                        : (!empty($employee->employee_address[0]->division_id)
                                            ? $employee->employee_address[0]->division_id
                                            : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'division_id_0',
                                        'placeholder' => 'Select Division',
                                        'onchange' => 'DivisionOnChange("0")',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="district_id">District </label>
                                <input type="hidden" id="district_key_0"
                                    value="{{ !empty($employee->employee_address[0]->district_id) ? $employee->employee_address[0]->district_id : null }}">
                                <select id="district_id_0" name="employee_address[0][district_id]"
                                    class="form-control select2"
                                    onchange='DistrictOnChange({{ !empty($employee->employee_address[0]->district_id) ? $employee->employee_address[0]->district_id : 0 }})'></select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="ps_id">Police Station</label>
                                <input type="hidden" id="ps_key_0"
                                    value="{{ !empty($employee->employee_address[0]->ps_id) ? $employee->employee_address[0]->ps_id : null }}">
                                <select id="ps_id_0" name="employee_address[0][ps_id]" class="form-control select2"
                                    onchange='PSOnChange("0")'></select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="po_id">Post Office</label>
                                <input type="hidden" id="po_key_0"
                                    value="{{ !empty($employee->employee_address[0]->po_id) ? $employee->employee_address[0]->po_id : null }}">
                                <select id="po_id_0" name="employee_address[0][po_id]"
                                    class="form-control select2"></select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="po_id">Address </label>
                                <textarea placeholder="Permanent Address" class="form-control" rows="5" id="address_0"
                                    name="employee_address[0][address]">{{ old('employee_address[0][address]') ? old('employee_address[0][address]') : (!empty($employee->employee_address[0]->address) ? $employee->employee_address[0]->address : null) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="po_id">Address Bangla</label>
                                <textarea placeholder="Permanent Address Bangla" class="form-control" rows="5" id="address_bangla_0"
                                    name="employee_address[0][address_bangla]">{{ old('employee_address[0][address_bangla]') ? old('employee_address[0][address_bangla]') : (!empty($employee->employee_address[0]->address_bangla) ? $employee->employee_address[0]->address_bangla : null) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 text-left pt-3 my-3"
                            style="font-size:medium; color:#75C3D8; border-top:1px solid #75C3D8;  border-bottom: 1px solid #75C3D8">
                            <span class="">Present Address</span>
                        </div>

                        <input type="hidden" id="address_type_1" name="employee_address[1][address_type]"
                            value="present" />

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="division_id_1">Division </label>
                                {{ Form::select(
                                    'employee_address[1][division_id]',
                                    $division,
                                    old('employee_address[1][division_id]')
                                        ? old('employee_address[1][division_id]')
                                        : (!empty($employee->employee_address[1]->division_id)
                                            ? $employee->employee_address[1]->division_id
                                            : null),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'division_id_1',
                                        'placeholder' => 'Select Division',
                                        'onchange' => 'DivisionOnChange("1")',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="district_id">District</label>
                                <input type="hidden" id="district_key_1"
                                    value="{{ !empty($employee->employee_address[1]->district_id) ? $employee->employee_address[1]->district_id : null }}">
                                <select id="district_id_1" name="employee_address[1][district_id]"
                                    class="form-control select2" onchange='DistrictOnChange("1")'></select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="ps_id_0">Police Station</label>
                                <input type="hidden" id="ps_key_1"
                                    value="{{ !empty($employee->employee_address[1]->ps_id) ? $employee->employee_address[1]->ps_id : null }}">
                                <select id="ps_id_1" name="employee_address[1][ps_id]" class="form-control select2"
                                    onchange='PSOnChange("1")'>
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="po_id">Post Office <span
                                        class="text-danger">*</span></label>
                                <input type="hidden" id="po_key_1"
                                    value="{{ !empty($employee->employee_address[1]->po_id) ? $employee->employee_address[1]->po_id : null }}">
                                <select id="po_id_1" name="employee_address[1][po_id]"
                                    class="form-control select2"></select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="address_1">Address <span
                                        class="text-danger">*</span></label>
                                <textarea placeholder="Present Address Bangla" class="form-control" rows="5" id="address_1"
                                    name="employee_address[1][address]">{{ old('employee_address[1][address]') ? old('employee_address[1][address]') : (!empty($employee->employee_address[1]->address) ? $employee->employee_address[1]->address : null) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="po_id">Address Bangla</label>
                                <textarea placeholder="Present Address Bangla" class="form-control" rows="5" id="address_bangla_1"
                                    name="employee_address[1][address_bangla]">{{ old('employee_address[1][address_bangla]') ? old('employee_address[1][address_bangla]') : (!empty($employee->employee_address[1]->address_bangla) ? $employee->employee_address[1]->address_bangla : null) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="bankinfo" role="tabpanel" aria-labelledby="bankinfo-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Bank Info</h1>
                    </div>
                    <div class="row p-3 bank-block">
                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="pay_mode_id">Pay Mode <span
                                        class="text-danger">*</span></label>
                                {{ Form::select(
                                    'employee_bank_info[pay_mode_id]',
                                    $paymode,
                                    old('employee_bank_info[pay_mode_id]')
                                        ? old('employee_bank_info[pay_mode_id]')
                                        : (!empty($employee->employee_bank_info->pay_mode_id)
                                            ? $employee->employee_bank_info->pay_mode_id
                                            : 1),
                                    [
                                        'class' => 'form-control select2 required-field',
                                        'id' => 'pay_mode_id',
                                        'placeholder' => 'Select Pay Mode',
                                        'required',
                                    ],
                                ) }}
                                @error('pay_mode_id')
                                    <p class="text-danger">{{ $errors->first('pay_mode_id') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="pay_mode_id">Bank </label>
                                {{ Form::select(
                                    'employee_bank_info[bank_id]',
                                    $bank,
                                    old('employee_bank_info[bank_id]')
                                        ? old('employee_bank_info[bank_id]')
                                        : (!empty($employee->employee_bank_info->bank_id)
                                            ? $employee->employee_bank_info->bank_id
                                            : null),
                                    [
                                        'class' => 'form-control select2 ',
                                        'id' => 'bank_id',
                                        'placeholder' => 'Select Bank',
                                        'onchange' => 'BankChange()',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="pay_mode_id">Branch </label>
                                <select id="branch_id" name="employee_bank_info[branch_id]" class="form-control select2">

                                </select>
                                @error('branch_id')
                                    <p class="text-danger">{{ $errors->first('branch_id') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="routing_number">Routing Number</label>
                                {{ Form::text(
                                    'employee_bank_info[routing_number]',
                                    old('employee_bank_info[routing_number]')
                                        ? old('employee_bank_info[routing_number]')
                                        : (!empty($employee->employee_bank_info->routing_number)
                                            ? $employee->employee_bank_info->routing_number
                                            : null),
                                    ['class' => 'form-control', 'id' => 'routing_number', 'placeholder' => 'Enter Routing Number Here'],
                                ) }}
                                @error('routing_number')
                                    <p class="text-danger">{{ $errors->first('routing_number') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="account_number">Account Number</label>
                                {{ Form::text(
                                    'employee_bank_info[account_number]',
                                    old('employee_bank_info[account_number]')
                                        ? old('employee_bank_info[account_number]')
                                        : (!empty($employee->employee_bank_info->account_number)
                                            ? $employee->employee_bank_info->account_number
                                            : null),
                                    ['class' => 'form-control', 'id' => 'account_number', 'placeholder' => 'Enter Account Number Here'],
                                ) }}
                                @error('account_number')
                                    <p class="text-danger">{{ $errors->first('account_number') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="account_name">Account Name</label>
                                {{ Form::text(
                                    'employee_bank_info[account_name]',
                                    old('employee_bank_info[account_name]')
                                        ? old('employee_bank_info[account_name]')
                                        : (!empty($employee->account_name)
                                            ? $employee->account_name
                                            : null),
                                    ['class' => 'form-control', 'id' => 'account_name', 'placeholder' => 'Enter Account Name Here'],
                                ) }}
                                @error('account_name')
                                    <p class="text-danger">{{ $errors->first('account_name') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="ac_type">Account Type</label>
                                {{ Form::text(
                                    'employee_bank_info[ac_type]',
                                    old('employee_bank_info[ac_type]')
                                        ? old('employee_bank_info[ac_type]')
                                        : (!empty($employee->employee_bank_info->ac_type)
                                            ? $employee->employee_bank_info->ac_type
                                            : null),
                                    ['class' => 'form-control', 'id' => 'ac_type', 'placeholder' => 'Enter Account Type Here'],
                                ) }}
                                @error('ac_type')
                                    <p class="text-danger">{{ $errors->first('ac_type') }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="family" role="tabpanel" aria-labelledby="family-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Family Info</h1>
                    </div>
                    <div class="row p-3 family-block">
                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="father_name">Father Name</label>
                                {{ Form::text(
                                    'employee_family_info[father_name]',
                                    old('employee_family_info[father_name]')
                                        ? old('employee_family_info[father_name]')
                                        : (!empty($employee->employee_family_info->father_name)
                                            ? $employee->employee_family_info->father_name
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'father_name',
                                        'placeholder' => 'Enter Father Name Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="father_name_bangla">Father Name Bangla</label>
                                {{ Form::text(
                                    'employee_family_info[father_name_bangla]',
                                    old('employee_family_info[father_name_bangla]')
                                        ? old('employee_family_info[father_name_bangla]')
                                        : (!empty($employee->employee_family_info->father_name_bangla)
                                            ? $employee->employee_family_info->father_name_bangla
                                            : null),
                                    ['class' => 'form-control', 'id' => 'father_name_bangla', 'placeholder' => 'Enter Father Name Bangla Here'],
                                ) }}
                                @error('father_name_bangla')
                                    <p class="text-danger">{{ $errors->first('father_name_bangla') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="father_nid">Father NID</label>
                                {{ Form::text(
                                    'employee_family_info[father_nid]',
                                    old('employee_family_info[father_nid]')
                                        ? old('employee_family_info[father_nid]')
                                        : (!empty($employee->employee_family_info->father_nid)
                                            ? $employee->employee_family_info->father_nid
                                            : null),
                                    ['class' => 'form-control', 'id' => 'father_nid', 'placeholder' => 'Enter Father NID Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="father_mobile">Father Mobile </label>
                                {{ Form::text(
                                    'employee_family_info[father_mobile]',
                                    old('employee_family_info[father_mobile]')
                                        ? old('employee_family_info[father_mobile]')
                                        : (!empty($employee->employee_family_info->father_mobile)
                                            ? $employee->employee_family_info->father_mobile
                                            : null),
                                    ['class' => 'form-control', 'id' => 'father_mobile', 'placeholder' => 'Enter Father Mobile Number Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="mother_name">Mother Name</label>
                                {{ Form::text(
                                    'employee_family_info[mother_name]',
                                    old('employee_family_info[mother_name]')
                                        ? old('employee_family_info[mother_name]')
                                        : (!empty($employee->employee_family_info->mother_name)
                                            ? $employee->employee_family_info->mother_name
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'mother_name',
                                        'placeholder' => 'Enter Mother Name Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="mother_name_bangla">Mother Name Bangla</label>
                                {{ Form::text(
                                    'employee_family_info[mother_name_bangla]',
                                    old('employee_family_info[mother_name_bangla]')
                                        ? old('employee_family_info[mother_name_bangla]')
                                        : (!empty($employee->employee_family_info->mother_name_bangla)
                                            ? $employee->employee_family_info->mother_name_bangla
                                            : null),
                                    ['class' => 'form-control', 'id' => 'mother_name_bangla', 'placeholder' => 'Enter Mother Name Bangla Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="mother_nid">Mother NID</label>
                                {{ Form::text(
                                    'employee_family_info[mother_nid]',
                                    old('employee_family_info[mother_nid]')
                                        ? old('employee_family_info[mother_nid]')
                                        : (!empty($employee->employee_family_info->mother_nid)
                                            ? $employee->employee_family_info->mother_nid
                                            : null),
                                    ['class' => 'form-control', 'id' => 'mother_nid', 'placeholder' => 'Enter Mother NID Here'],
                                ) }}
                                @error('mother_nid')
                                    <p class="text-danger">{{ $errors->first('mother_nid') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="mother_mobile">Mother Mobile</label>
                                {{ Form::text(
                                    'employee_family_info[mother_mobile]',
                                    old('employee_family_info[mother_mobile]')
                                        ? old('employee_family_info[mother_mobile]')
                                        : (!empty($employee->employee_family_info->mother_mobile)
                                            ? $employee->employee_family_info->mother_mobile
                                            : null),
                                    ['class' => 'form-control', 'id' => 'mother_mobile', 'placeholder' => 'Enter Mother Mobile Number Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon mr-5" for="is_married">Married</label>
                                {{ Form::checkbox('employee_family_info[is_married]', 0, old('employee_family_info[is_married]') && old('employee_family_info[is_married]') == 1 ? true : (!empty($employee->employee_family_info->is_married) && $employee->employee_family_info->is_married == 1 ? true : false), ['class' => 'employee-checkboxes', 'id' => 'is_married']) }}
                            </div>
                        </div>
                        <div class="col-12 spouse-info"
                            style="{{ old('employee_family_info[is_married]') && old('employee_family_info[is_married]') == 1 ? '' : (!empty($employee->employee_family_info->is_married) && $employee->employee_family_info->is_married == 1 ? '' : 'display:none') }}">
                            <div class="row">
                                <div class="col-6">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="spouse_name">Spouse Name</label>
                                        {{ Form::text(
                                            'employee_family_info[spouse_name]',
                                            old('employee_family_info[spouse_name]')
                                                ? old('employee_family_info[spouse_name]')
                                                : (!empty($employee->employee_family_info->spouse_name)
                                                    ? $employee->employee_family_info->spouse_name
                                                    : null),
                                            ['class' => 'form-control', 'id' => 'spouse_name', 'placeholder' => 'Enter Spouse Name Here'],
                                        ) }}
                                        @error('spouse_name')
                                            <p class="text-danger">{{ $errors->first('spouse_name') }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="spouse_name_bangla">Spouse Name
                                            Bangla</label>
                                        {{ Form::text(
                                            'employee_family_info[spouse_name_bangla]',
                                            old('employee_family_info[spouse_name_bangla]')
                                                ? old('employee_family_info[spouse_name_bangla]')
                                                : (!empty($employee->employee_family_info->spouse_name_bangla)
                                                    ? $employee->employee_family_info->spouse_name_bangla
                                                    : null),
                                            ['class' => 'form-control', 'id' => 'spouse_name_bangla', 'placeholder' => 'Enter Spouse Name Bangla Here'],
                                        ) }}
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="spouse_nid">Spouse NID</label>
                                        {{ Form::text(
                                            'employee_family_info[spouse_nid]',
                                            old('employee_family_info[spouse_nid]')
                                                ? old('employee_family_info[spouse_nid]')
                                                : (!empty($employee->employee_family_info->spouse_nid)
                                                    ? $employee->employee_family_info->spouse_nid
                                                    : null),
                                            ['class' => 'form-control', 'id' => 'spouse_nid', 'placeholder' => 'Enter Spouse NID Here'],
                                        ) }}
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="spouse_mobile">Spouse Mobile</label>
                                        {{ Form::text(
                                            'employee_family_info[spouse_mobile]',
                                            old('employee_family_info[spouse_mobile]')
                                                ? old('employee_family_info[spouse_mobile]')
                                                : (!empty($employee->employee_family_info->spouse_mobile)
                                                    ? $employee->employee_family_info->spouse_mobile
                                                    : null),
                                            ['class' => 'form-control', 'id' => 'spouse_mobile', 'placeholder' => 'Enter Spouse Mobile Number Here'],
                                        ) }}
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group input-group-sm input-group-primary">
                                        <label class="input-group-addon" for="child_number">Child Number</label>
                                        {{ Form::text(
                                            'employee_family_info[child_number]',
                                            old('employee_family_info[child_number]')
                                                ? old('employee_family_info[child_number]')
                                                : (!empty($employee->employee_family_info->child_number)
                                                    ? $employee->employee_family_info->child_number
                                                    : null),
                                            ['class' => 'form-control', 'id' => 'child_number', 'placeholder' => 'Enter Children Count Here'],
                                        ) }}
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="nominee" role="tabpanel" aria-labelledby="nominee-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Nominee Info</h1>
                    </div>
                    <div class="row p-3 nominee-block">
                        <div class="col-12 text-left mb-3"
                            style="font-size:medium; color:#75C3D8; border-bottom: 1px solid #75C3D8">
                            <span class="">First Nominee Info</span>
                        </div>
                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_name">Nominee Name</label>
                                {{ Form::text(
                                    'employee_nominee_info[0][nominee_name]',
                                    old('employee_nominee_info[0][nominee_name]')
                                        ? old('employee_nominee_info[0][nominee_name]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_name)
                                            ? $employee->employee_nominee_info[0]->nominee_name
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_name_0',
                                        'placeholder' => 'Enter Nominee Name Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_dob">Nominee DOB </label>
                                {{ Form::date(
                                    'employee_nominee_info[0][nominee_dob]',
                                    old('employee_nominee_info[0][nominee_dob]')
                                        ? old('employee_nominee_info[0][nominee_dob]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_dob)
                                            ? $employee->employee_nominee_info[0]->nominee_dob
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_dob_0',
                                        'placeholder' => 'Enter Nominee DOB Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_proffession">Nominee Proffesion </label>
                                {{ Form::text(
                                    'employee_nominee_info[0][nominee_proffession]',
                                    old('employee_nominee_info[0][nominee_proffession]')
                                        ? old('employee_nominee_info[0][nominee_proffession]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_proffession)
                                            ? $employee->employee_nominee_info[0]->nominee_proffession
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_proffession_0',
                                        'placeholder' => 'Enter Nominee DOB Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_mobile">Nominee Mobile</label>
                                {{ Form::text(
                                    'employee_nominee_info[0][nominee_mobile]',
                                    old('employee_nominee_info[0][nominee_mobile]')
                                        ? old('employee_nominee_info[0][nominee_mobile]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_mobile)
                                            ? $employee->employee_nominee_info[0]->nominee_mobile
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_mobile_0',
                                        'placeholder' => 'Enter Nominee Mobile Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_nid">Nominee NID</label>
                                {{ Form::text(
                                    'employee_nominee_info[0][nominee_nid]',
                                    old('employee_nominee_info[0][nominee_nid]')
                                        ? old('employee_nominee_info[0][nominee_nid]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_nid)
                                            ? $employee->employee_nominee_info[0]->nominee_nid
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_nid_0',
                                        'placeholder' => 'Enter Nominee NID Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_relation">Nominee Relation</label>
                                {{ Form::text(
                                    'employee_nominee_info[0][nominee_relation]',
                                    old('employee_nominee_info[0][nominee_relation]')
                                        ? old('employee_nominee_info[0][nominee_relation]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_relation)
                                            ? $employee->employee_nominee_info[0]->nominee_relation
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_relation_0',
                                        'placeholder' => 'Enter Nominee Relation Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon px-2" for="nominee_percentage">Nominee Percentage</label>
                                {{ Form::text(
                                    'employee_nominee_info[0][nominee_percentage]',
                                    old('employee_nominee_info[0][nominee_percentage]')
                                        ? old('employee_nominee_info[0][nominee_percentage]')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_percentage)
                                            ? $employee->employee_nominee_info[0]->nominee_percentage
                                            : null),
                                    [
                                        'class' => 'form-control required-field',
                                        'id' => 'nominee_percentage_0',
                                        'placeholder' => 'Enter Nominee Percentage Here',
                                    ],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_address">Nominee Address</label>
                                <textarea class="form-control" id="nominee_address_0" name="employee_nominee_info[0][nominee_address]"
                                    placeholder="Enter Nominee Percentage Here">{{ old('nominee_address')
                                        ? old('nominee_address')
                                        : (!empty($employee->employee_nominee_info[0]->nominee_address)
                                            ? $employee->employee_nominee_info[0]->nominee_address
                                            : null) }}</textarea>
                            </div>
                        </div>

                        <div class="col-12 text-left mb-3"
                            style="font-size:medium; color:#75C3D8; border-bottom: 1px solid #75C3D8">
                            <span class="">Second Nominee Info</span>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_name">Nominee Name</label>
                                {{ Form::text(
                                    'employee_nominee_info[1][nominee_name]',
                                    old('employee_nominee_info[1][nominee_name]')
                                        ? old('employee_nominee_info[1][nominee_name]')
                                        : (!empty($employee->employee_nominee_info[1]->nominee_name)
                                            ? $employee->employee_nominee_info[1]->nominee_name
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_name_1', 'placeholder' => 'Enter Nominee Name Here'],
                                ) }}
                                @error('nominee_name')
                                    <p class="text-danger">{{ $errors->first('nominee_name') }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_dob">Nominee DOB</label>
                                {{ Form::date(
                                    'employee_nominee_info[1][nominee_dob]',
                                    old('employee_nominee_info[1][nominee_dob]')
                                        ? old('employee_nominee_info[1][nominee_dob]')
                                        : (!empty($employee->employee_nominee_info[1]->nominee_dob)
                                            ? $employee->employee_nominee_info[1]->nominee_dob
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_dob_1', 'placeholder' => 'Enter Nominee DOB Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_proffession">Nominee Proffesion</label>
                                {{ Form::text(
                                    'employee_nominee_info[1][nominee_proffession]',
                                    old('employee_nominee_info[1][nominee_proffession]')
                                        ? old('employee_nominee_info[1][nominee_proffession]')
                                        : (!empty($employee->employee_nominee_info[1]->nominee_proffession)
                                            ? $employee->employee_nominee_info[1]->nominee_proffession
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_proffession_1', 'placeholder' => 'Enter Nominee DOB Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_mobile">Nominee Mobile</label>
                                {{ Form::text(
                                    'employee_nominee_info[1][nominee_mobile]',
                                    old('employee_nominee_info[1][nominee_mobile]')
                                        ? old('employee_nominee_info[1][nominee_mobile]')
                                        : (!empty($employee->nominee_mobile)
                                            ? $employee->nominee_mobile
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_mobile_1', 'placeholder' => 'Enter Nominee Mobile Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_nid">Nominee NID</label>
                                {{ Form::text(
                                    'employee_nominee_info[1][nominee_nid]',
                                    old('employee_nominee_info[1][nominee_nid]')
                                        ? old('employee_nominee_info[1][nominee_nid]')
                                        : (!empty($employee->nominee_nid)
                                            ? $employee->nominee_nid
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_nid_1', 'placeholder' => 'Enter Nominee NID Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_relation">Nominee Relation</label>
                                {{ Form::text(
                                    'employee_nominee_info[1][nominee_relation]',
                                    old('employee_nominee_info[1][nominee_relation]')
                                        ? old('employee_nominee_info[1][nominee_relation]')
                                        : (!empty($employee->employee_nominee_info[1]->nominee_relation)
                                            ? $employee->employee_nominee_info[1]->nominee_relation
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_relation_1', 'placeholder' => 'Enter Nominee Relation Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_percentage">Nominee Percentage</label>
                                {{ Form::text(
                                    'employee_nominee_info[1][nominee_percentage]',
                                    old('employee_nominee_info[1][nominee_percentage]')
                                        ? old('employee_nominee_info[1][nominee_percentage]')
                                        : (!empty($employee->employee_nominee_info[1]->nominee_percentage)
                                            ? $employee->employee_nominee_info[1]->nominee_percentage
                                            : null),
                                    ['class' => 'form-control', 'id' => 'nominee_percentage_1', 'placeholder' => 'Enter Nominee Percentage Here'],
                                ) }}
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="nominee_address">Nominee Percentage</label>
                                <textarea class="form-control" id="nominee_address_1" name="employee_nominee_info[1][nominee_address]"
                                    placeholder="Enter Nominee Percentage Here">{{ old('nominee_address')
                                        ? old('nominee_address')
                                        : (!empty($employee->employee_nominee_info[1]->nominee_address)
                                            ? $employee->employee_nominee_info[1]->nominee_address
                                            : null) }}</textarea>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="tab-pane fade" id="education" role="tabpanel" aria-labelledby="education-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Employee Educations</h1>
                    </div>
                    <div class="row p-3 education-block">
                        <table class="table table-striped table-bordered" id="education_table">
                            <thead>
                                <tr>
                                    <th>Exam<span class="text-danger">*</span></th>
                                    <th>Grade<span class="text-danger">*</span></th>
                                    <th>Major<span class="text-danger">*</span></th>
                                    <th>Institute<span class="text-danger">*</span></th>
                                    <th>Board<span class="text-danger">*</span></th>
                                    <th>Passing Year<span class="text-danger">*</span></th>
                                    <th><button type="button" class="btn btn-sm add-education"><i
                                                class="ti-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty(old('employee_education')))
                                    @foreach (old('employee_education') as $key => $value)
                                        <tr id="row_{{ $key }}">
                                            <td>
                                                <input placeholder="Exam Name" type="text"
                                                    class="form-control required-field"
                                                    id="exam_name_{{ $key }}"
                                                    name="employee_education[{{ $key }}][exam_name]"
                                                    value="{{ $value['exam_name'] }}">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="Exam Result"
                                                    class="form-control required-field"
                                                    id="exam_result_{{ $key }}"
                                                    name="employee_education[{{ $key }}][exam_result]"
                                                    value="{{ $value['exam_result'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="Exam Major" type="text"
                                                    class="form-control required-field"
                                                    id="exam_major_{{ $key }}"
                                                    name="employee_education[{{ $key }}][major]"
                                                    value="{{ $value['major'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="Institute Name" type="text"
                                                    class="form-control required-field"
                                                    id="exam_institute_name_{{ $key }}"
                                                    name="employee_education[{{ $key }}][institute_name]"
                                                    value="{{ $value['institute_name'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="Board Name" type="text"
                                                    class="form-control required-field"
                                                    id="board_name_{{ $key }}"
                                                    name="employee_education[{{ $key }}][board_name]"
                                                    value="{{ $value['board_name'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="Passing Year" type="text"
                                                    class="form-control required-field"
                                                    id="passing_year_{{ $key }}"
                                                    name="employee_education[{{ $key }}][passing_year]"
                                                    value="{{ $value['passing_year'] }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif (!empty($employee->employee_education))
                                    @foreach ($employee->employee_education as $key => $value)
                                        <tr id="row_{{ $key }}">
                                            <td>
                                                <input placeholder="Exam Name" type="text"
                                                    class="form-control required-field"
                                                    id="exam_name_{{ $key }}"
                                                    name="employee_education[{{ $key }}][exam_name]"
                                                    value="{{ $value->exam_name }}">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="Exam Result"
                                                    class="form-control required-field"
                                                    id="exam_result_{{ $key }}"
                                                    name="employee_education[{{ $key }}][exam_result]"
                                                    value="{{ $value->exam_result }}">
                                            </td>
                                            <td>
                                                <input placeholder="Exam Major" type="text"
                                                    class="form-control required-field"
                                                    id="exam_major_{{ $key }}"
                                                    name="employee_education[{{ $key }}][major]"
                                                    value="{{ $value->major }}">
                                            </td>
                                            <td>
                                                <input placeholder="Institute Name" type="text"
                                                    class="form-control required-field"
                                                    id="exam_institute_name_{{ $key }}"
                                                    name="employee_education[{{ $key }}][institute_name]"
                                                    value="{{ $value->institute_name }}">
                                            </td>
                                            <td>
                                                <input placeholder="Board Name" type="text"
                                                    class="form-control required-field"
                                                    id="board_name_{{ $key }}"
                                                    name="employee_education[{{ $key }}][board_name]"
                                                    value="{{ $value->board_name }}">
                                            </td>
                                            <td>
                                                <input placeholder="Passing Year" type="text"
                                                    class="form-control required-field"
                                                    id="passing_year_{{ $key }}"
                                                    name="employee_education[{{ $key }}][passing_year]"
                                                    value="{{ $value->passing_year }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="row_1">
                                        <td>
                                            <input placeholder="Exam Name" type="text"
                                                class="form-control required-field" id="exam_name_1"
                                                name="employee_education[1][exam_name]">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Exam Result"
                                                class="form-control required-field" id="exam_result_1"
                                                name="employee_education[1][exam_result]">
                                        </td>
                                        <td>
                                            <input placeholder="Exam Major" type="text"
                                                class="form-control required-field" id="exam_major_1"
                                                name="employee_education[1][major]">
                                        </td>
                                        <td>
                                            <input placeholder="Institute Name" type="text"
                                                class="form-control required-field" id="exam_institute_name_1"
                                                name="employee_education[1][institute_name]">
                                        </td>
                                        <td>
                                            <input placeholder="Board Name" type="text"
                                                class="form-control required-field" id="board_name_1"
                                                name="employee_education[1][board_name]">
                                        </td>
                                        <td>
                                            <input placeholder="Passing Year" type="text"
                                                class="form-control required-field" id="passing_year_1"
                                                name="employee_education[1][passing_year]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif



                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="experience" role="tabpanel" aria-labelledby="experience-tab">
                    <div class="tab-headings">
                        <h1 class="sub-title">Employee Experience</h1>
                    </div>
                    <div class="row p-3 experience-block">
                        <table class="table table-striped table-bordered" id="experience_table">
                            <thead>
                                <tr>
                                    <th>Comapny Name</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Remarks</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th><button type="button" class="btn btn-sm add-experience"><i
                                                class="ti-plus"></i></button></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty(old('employee_experience')))
                                    @foreach (old('employee_experience') as $key => $value)
                                        <tr id="row_{{ $key }}">
                                            <td>
                                                <input placeholder="Company Name" type="text" class="form-control "
                                                    id="company_name_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][company_name]"
                                                    value="{{ $value['company_name'] }}">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="Designation" class="form-control "
                                                    id="designation_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][designation]"
                                                    value="{{ $value['designation'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="Salary" type="text" class="form-control "
                                                    id="salary_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][salary]"
                                                    value="{{ $value['salary'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="Ramarks" type="text" class="form-control "
                                                    id="remarks_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][remarks]"
                                                    value="{{ $value['remarks'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="From Date" type="text" class="form-control "
                                                    id="from_date_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][from_date]"
                                                    value="{{ $value['from_date'] }}">
                                            </td>
                                            <td>
                                                <input placeholder="To Date" type="text" class="form-control "
                                                    id="to_date_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][to_date]"
                                                    value="{{ $value['to_date'] }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @elseif (!empty($employee->employee_experience))
                                    @foreach ($employee->employee_experience as $key => $value)
                                        <tr id="row_{{ $key }}">
                                            <td>
                                                <input placeholder="Company Name" type="text" class="form-control "
                                                    id="company_name_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][company_name]"
                                                    value="{{ $value->company_name }}">
                                            </td>
                                            <td>
                                                <input type="text" placeholder="Designation" class="form-control "
                                                    id="designation_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][designation]"
                                                    value="{{ $value->designation }}">
                                            </td>
                                            <td>
                                                <input placeholder="Salary" type="text" class="form-control "
                                                    id="salary_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][salary]"
                                                    value="{{ $value->salary }}">
                                            </td>
                                            <td>
                                                <input placeholder="Ramarks" type="text" class="form-control "
                                                    id="remarks_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][remarks]"
                                                    value="{{ $value->remarks }}">
                                            </td>
                                            <td>
                                                <input placeholder="From Date" type="text" class="form-control "
                                                    id="from_date_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][from_date]"
                                                    value="{{ $value->from_date }}">
                                            </td>
                                            <td>
                                                <input placeholder="To Date" type="text" class="form-control "
                                                    id="to_date_{{ $key }}"
                                                    name="employee_experience[{{ $key }}][to_date]"
                                                    value="{{ $value->to_date }}">
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-row">
                                                    <i class="ti-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr id="row_1">
                                        <td>
                                            <input placeholder="Company Name" type="text" class="form-control "
                                                id="company_name_1" name="employee_experience[1][company_name]">
                                        </td>
                                        <td>
                                            <input type="text" placeholder="Designation" class="form-control "
                                                id="designation_1" name="employee_experience[1][designation]">
                                        </td>
                                        <td>
                                            <input placeholder="Salary" type="text" class="form-control "
                                                id="salary_1" name="employee_experience[1][salary]">
                                        </td>
                                        <td>
                                            <input placeholder="Ramarks" type="text" class="form-control "
                                                id="remarks_1" name="employee_experience[1][remarks]">
                                        </td>
                                        <td>
                                            <input placeholder="From Date" type="text" class="form-control "
                                                id="from_date_1" name="employee_experience[1][from_date]">
                                        </td>
                                        <td>
                                            <input placeholder="To Date" type="text" class="form-control "
                                                id="to_date_1" name="employee_experience[1][to_date]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm remove-row">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>





    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection

@php
    $division_id_0 = old('employee_address[0][division_id]') ? old('employee_address[0][division_id]') : (!empty($employee->employee_address[0]->division_id) ? $employee->employee_address[0]->division_id : null);
    $district_id_0 = old('employee_address[0][district_id]') ? old('employee_address[0][district_id]') : (!empty($employee->employee_address[0]->district_id) ? $employee->employee_address[0]->district_id : null);
    $ps_id_0 = old('employee_address[0][ps_id]') ? old('employee_address[0][ps_id]') : (!empty($employee->employee_address[0]->ps_id) ? $employee->employee_address[0]->ps_id : null);
    $po_id_0 = old('employee_address[0][po_id]') ? old('employee_address[0][po_id]') : (!empty($employee->employee_address[0]->po_id) ? $employee->employee_address[0]->po_id : null);

    $division_id_1 = old('employee_address[1][division_id]') ? old('employee_address[1][division_id]') : (!empty($employee->employee_address[1]->division_id) ? $employee->employee_address[1]->division_id : null);
    $district_id_1 = old('employee_address[1][district_id]') ? old('employee_address[1][district_id]') : (!empty($employee->employee_address[1]->district_id) ? $employee->employee_address[1]->district_id : null);
    $ps_id_1 = old('employee_address[1][ps_id]') ? old('employee_address[1][ps_id]') : (!empty($employee->employee_address[1]->ps_id) ? $employee->employee_address[1]->ps_id : null);
    $po_id_1 = old('employee_address[1][po_id]') ? old('employee_address[1][po_id]') : (!empty($employee->employee_address[1]->po_id) ? $employee->employee_address[1]->po_id : null);

    $bank_id = old('employee_bank_info[bank_id]') ? old('employee_bank_info[bank_id]') : (!empty($employee->employee_bank_info->bank_id) ? $employee->employee_bank_info->bank_id : null);
@endphp

@section('script')
    <script>
        $(document).ready(function() {

            let division_id_0 = '{{ $division_id_0 }}';
            let district_id_0 = '{{ $district_id_0 }}';
            let ps_id_0 = '{{ $ps_id_0 }}';
            let po_id_0 = '{{ $po_id_0 }}';
            LoadDistrictDropDown(division_id_0, 0);
            LoadPoliceStationDropDown(district_id_0, 0);
            LoadPostOfficeDropDown(ps_id_0, 0);

            let division_id_1 = '{{ $division_id_1 }}';
            let district_id_1 = '{{ $district_id_1 }}';
            let ps_id_1 = '{{ $ps_id_1 }}';
            let po_id_1 = '{{ $po_id_1 }}';
            LoadDistrictDropDown(division_id_1, 1);
            LoadPoliceStationDropDown(district_id_1, 1);
            LoadPostOfficeDropDown(ps_id_1, 1);

            let bank_id = '{{ $bank_id }}';
            LoadBankBranchDropDown(bank_id)


            $('#myTab a').on('click', function(e) {
                e.preventDefault()
                $(this).tab('show')
                console.log($(this).attr('href'))
            })

            $('.employee-checkboxes').change(function() {
                if ($(this).is(':checked')) {
                    // Checkbox is checked
                    $(this).val('1');

                    // Perform any desired actions when checkbox is checked
                } else {
                    // Checkbox is unchecked
                    $(this).val('0');
                    // Perform any desired actions when checkbox is unchecked
                }
            });


            $('#is_married').change(function() {
                if ($(this).is(':checked')) {
                    $('.spouse-info').fadeIn(1000);
                } else {
                    $('.spouse-info').fadeOut(500);

                }
            })

            //add row
            let education_index = 1;
            $(document).on("click", ".add-education", function() {
                education_index++;
                let html = `    <tr id="row_${education_index}">
                                    <td>
                                        <input placeholder="Exam Name" type="text" class="form-control" id="exam_name" name="employee_education[${education_index}][exam_name]">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Exam Result" class="form-control" id="exam_result_${education_index}" name="employee_education[${education_index}][exam_result]">
                                    </td>
                                    <td>
                                        <input placeholder="Exam Major" type="text" class="form-control" id="exam_major_${education_index}" name="employee_education[${education_index}][major]">
                                    </td>
                                    <td>
                                        <input placeholder="Institute Name" type="text" class="form-control" id="exam_institute_name_${education_index}" name="employee_education[${education_index}][institute_name]">
                                    </td>
                                    <td>
                                        <input placeholder="Board Name" type="text" class="form-control" id="board_name_${education_index}" name="employee_education[${education_index}][board_name]">
                                    </td>
                                    <td>
                                        <input placeholder="Passing Year" type="text" class="form-control" id="passing_year_${education_index}" name="employee_education[${education_index}][passing_year]">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </td>
                                </tr>`

                $('#education_table tbody').append(html);
            });

            let experience_index = 1;
            $(document).on("click", ".add-experience", function() {
                experience_index++;
                let html = `    <tr id="row_${experience_index}">
                                    <td>
                                        <input placeholder="Company Name" type="text" class="form-control"
                                            id="company_name_${experience_index}" name="employee_experience[${experience_index}][company_name]">
                                    </td>
                                    <td>
                                        <input type="text" placeholder="Designation" class="form-control"
                                            id="designation_${experience_index}" name="employee_experience[${experience_index}][designation]">
                                    </td>
                                    <td>
                                        <input placeholder="Salary" type="text" class="form-control"
                                            id="salary_${experience_index}" name="employee_experience[${experience_index}][salary]">
                                    </td>
                                    <td>
                                        <input placeholder="Ramarks" type="text" class="form-control"
                                            id="remarks_${experience_index}" name="employee_experience[${experience_index}][remarks]">
                                    </td>
                                    <td>
                                        <input placeholder="From Date" type="text" class="form-control"
                                            id="from_date_${experience_index}" name="employee_experience[${experience_index}][from_date]">
                                    </td>
                                    <td>
                                        <input placeholder="To Date" type="text" class="form-control"
                                            id="to_date_${experience_index}" name="employee_experience[${experience_index}][to_date]">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="ti-minus"></i>
                                        </button>
                                    </td>
                                </tr>`

                $('#experience_table tbody').append(html);
            });

            //remove row
            $(document).on("click", ".remove-row", function() {
                $(this).closest("tr").remove();
            });

        })

        // Division change event handler
        function DivisionOnChange(index) {
            var selectedDivision = $(`#division_id_${index}`).val();
            LoadDistrictDropDown(selectedDivision, index);
        };

        // District change event handler
        function DistrictOnChange(index) {

            var selectedDistrict = $(`#district_id_${index}`).val();
            LoadPoliceStationDropDown(selectedDistrict, index);
        };

        // District change event handler
        function PSOnChange(index) {
            var selectedPS = $(`#ps_id_${index}`).val();
            LoadPostOfficeDropDown(selectedPS, index);
        };


        // Bank change event handler
        function BankChange() {
            var selectedBank = $(`#bank_id`).val();
            LoadBankBranchDropDown(selectedBank);
        };


        function LoadDistrictDropDown(divisionId, index) {

            var key = $(`#district_key_${index}`).val();

            // alert(key);
            if (divisionId) {
                $.ajax({
                    url: '{{ route('fetchDistricts') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'division_id': divisionId,
                        'key': key
                    },
                    success: function(data) {
                        // Update the Division dropdown with the fetched divisions
                        $(`#district_id_${index}`).html(data);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function LoadPoliceStationDropDown(districtId, index) {

            let key = $(`#ps_key_${index}`).val();

            if (districtId) {

                $.ajax({
                    url: '{{ route('fetchPoliceStation') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'district_id': districtId,
                        'key': key
                    },
                    success: function(data) {
                        //console.log(data);
                        // Update the Division dropdown with the fetched divisions
                        $(`#ps_id_${index}`).html(data);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function LoadPostOfficeDropDown(policeStationId, index) {
            let key = $(`#po_key_${index}`).val();
            // alert(key);
            if (policeStationId) {
                $.ajax({
                    url: '{{ route('fetchPostOffice') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'police_station_id': policeStationId,
                        'key': key
                    },
                    success: function(data) {
                        //console.log(data);
                        // Update the Division dropdown with the fetched divisions
                        $(`#po_id_${index}`).html(data);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        function LoadBankBranchDropDown(selectedBank) {
            if (selectedBank) {
                $.ajax({
                    url: '{{ route('fetchBankBranch') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'bank_id': selectedBank
                    },
                    success: function(data) {
                        //console.log(data);
                        // Update the Division dropdown with the fetched divisions
                        $(`#branch_id`).html(data);

                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        }

        $(".nav-link.disabled").click(function(event) {
            event.preventDefault(); // Prevent the default click behavior
            return false; // Stop the event propagation
        });



        // $(".personal-block input, .personal-block select").on('change', function() {
        //     var filled = true;

        //     $(".personal-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#details-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#details-tab").addClass('disabled');
        //     }
        // });

        // $(".detail-block input, .detail-block select").on('change', function() {
        //     var filled = true;

        //     $(".detail-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#address-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#address-tab").addClass('disabled');
        //     }
        // });

        // $(".address-block input, .address-block select").on('change', function() {
        //     var filled = true;

        //     $(".address-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#bankinfo-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#bankinfo-tab").addClass('disabled');
        //     }
        // });

        // $(".bank-block input, .bank-block select").on('change', function() {
        //     var filled = true;

        //     $(".bank-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#family-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#family-tab").addClass('disabled');
        //     }
        // });

        // $(".family-block input, .family-block select").on('change', function() {
        //     var filled = true;

        //     $(".family-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#nominee-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#nominee-tab").addClass('disabled');
        //     }
        // });

        // $(".nominee-block input, .nominee-block select").on('change', function() {
        //     var filled = true;

        //     $(".nominee-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#education-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#education-tab").addClass('disabled');
        //     }
        // });

        // $(".education-block input, .education-block select").on('change', function() {
        //     var filled = true;

        //     $(".education-block .required-field").each(function() {
        //         var fieldValue = $(this).val();

        //         if (fieldValue === "") {
        //             filled = false;
        //             return false; // Exit the loop if an empty required field is found
        //         }
        //     });

        //     if (filled) {
        //         // All required fields in the div are filled
        //         $("#experience-tab").removeClass('disabled');
        //     } else {
        //         // There are empty required fields in the div
        //         $("#experience-tab").addClass('disabled');
        //     }
        // });

        $("#pay_mode_id").on('change', function() {
            if ($(this).val() === '2') {
                $('[name^="employee_bank_info"]').each(function() {
                    $(this).prop('required', true);
                });
            } else {
                $('[name^="employee_bank_info"]').each(function() {
                    $(this).prop('required', false);
                });
                $("#pay_mode_id").prop('required', true);
            }
        });

        $("#fingerprint_device_id").on('change',function (e) {
            $('#finger_id').val('');
            $('#finger_id_live_error').html('');
        })

        $('#finger_id').on('change', function() {

            if ($("#fingerprint_device_id").val() === '') {
                $('#finger_id_live_error').html('Please Select A Device ');
                $(this).val('')
                return;
            }

            if ($("#finger_id").val() === '') {
                $('#finger_id_live_error').html('');
                return;
            }

            $('#finger_id_live_error').html('');
            $.ajax({

                url: "{{ url('hr/is-fingerid-unique') }}" + '/' + $('#fingerprint_device_id').val() + '/' + $(this).val() + '/' + $('#emp_id')
                    .val(),
                type: 'GET',

                success: function(data) {
                    $('#finger_id_live_error').html('');
                },
                error: function(xhr, status, error) {
                    $('#finger_id_live_error').html(xhr.responseJSON.message);
                }
            });
        })

        // preview uploaded employee image
        $('#emp_img').on('change', function() {
            const emp_img_preview = document.getElementById('emp_img_preview');

            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    emp_img_preview.src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

@endsection
