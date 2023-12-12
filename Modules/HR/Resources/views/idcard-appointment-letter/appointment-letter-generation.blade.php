@extends('layouts.backend-layout')
@section('title', 'Generate Appointment Letter')

@section('breadcrumb-title')
    Generate Appointment Letter
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('appointmentLettersList') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    {!! Form::open([
        'url' => 'hr/appointment-letter-generation',
        'method' => 'POST',
        'class' => 'custom-form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}

    <div class="row">



        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Employee Name<span class="text-danger">*</span></label>
                {{ Form::text('employee_name', old('employee_name') ? old('employee_name') : '', [
                    'class' => 'form-control',
                    'id' => 'employee_name',
                    'placeholder' => 'Enter Employee Name..',
                ]) }}
            </div>
            @error('employee_name')
                <p class="text-danger">{{ $errors->first('employee_name') }}</p>
            @enderror
        </div>

        <div class="col-12 my-2" id="terms_and_conditions_container">
            <div>
                <label class="input-group" for="name">Employee Address <span class="text-danger">*</span> </label>
                <textarea name="employee_address" id="employee_address" cols="30" rows="2" class="mtl-summernote">{{ old('employee_address') ? old('employee_address') : null }}</textarea>
            </div>
            @error('employee_address')
                <p class="text-danger">{{ $errors->first('employee_address') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Employee Department<span class="text-danger">*</span></label>
                {{ Form::text('employee_department', old('employee_department') ? old('employee_department') : '', [
                    'class' => 'form-control',
                    'id' => 'employee_department',
                    'placeholder' => 'Enter Employee Name..',
                ]) }}
            </div>
            @error('employee_department')
                <p class="text-danger">{{ $errors->first('employee_department') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Employee Designation<span class="text-danger">*</span></label>
                {{ Form::text('employee_designation', old('employee_designation') ? old('employee_designation') : '', [
                    'class' => 'form-control',
                    'id' => 'employee_designation',
                    'placeholder' => 'Enter Employee designation..',
                ]) }}
            </div>
            @error('employee_designation')
                <p class="text-danger">{{ $errors->first('employee_designation') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Employee Job Location<span class="text-danger">*</span></label>
                {{ Form::text('employee_job_location', old('employee_job_location') ? old('employee_job_location') : '', [
                    'class' => 'form-control',
                    'id' => 'employee_job_location',
                    'placeholder' => 'Enter Employee Job Location..',
                ]) }}
            </div>
            @error('employee_job_location')
                <p class="text-danger">{{ $errors->first('employee_job_location') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Company Name:<span class="text-danger">*</span></label>
                {{ Form::text('posted_to_company_name', old('posted_to_company_name') ? old('posted_to_company_name') : '', [
                    'class' => 'form-control',
                    'id' => 'posted_to_company_name',
                    'placeholder' => 'Enter Company Name:..',
                ]) }}
            </div>
            @error('posted_to_company_name')
                <p class="text-danger">{{ $errors->first('posted_to_company_name') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Joining Date<span class="text-danger">*</span></label>
                {{ Form::date('employee_joining_date', old('employee_joining_date') ? old('employee_joining_date') : '', [
                    'class' => 'form-control',
                    'id' => 'employee_joining_date'
                ]) }}
            </div>
            @error('employee_joining_date')
                <p class="text-danger">{{ $errors->first('employee_joining_date') }}</p>
            @enderror
        </div>

        <div class="col-12 my-2">
            <div>
                <label class="input-group" for="name">Terms and Condition for Employee <span
                        class="text-danger">*</span>
                </label>
                <textarea name="terms_and_conditions" id="terms_and_conditions" cols="30" rows="2" class="mtl-summernote">{{ old('terms_and_conditions') ? old('terms_and_conditions') : null }}</textarea>
            </div>
            @error('terms_and_conditions')
                <p class="text-danger">{{ $errors->first('terms_and_conditions') }}</p>
            @enderror
        </div>


        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Letter Issue Date<span class="text-danger">*</span></label>
                {{ Form::date('letter_issue_date', old('letter_issue_date') ? old('letter_issue_date') : '', [
                    'class' => 'form-control',
                    'id' => 'letter_issue_date'
                ]) }}
            </div>
            @error('letter_issue_date')
                <p class="text-danger">{{ $errors->first('letter_issue_date') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Letter Issuer Name<span class="text-danger">*</span></label>
                {{ Form::text('letter_issuer_name', old('letter_issuer_name') ? old('letter_issuer_name') : '', [
                    'class' => 'form-control',
                    'id' => 'letter_issuer_name',
                    'placeholder' => 'Letter Issuer Name',
                ]) }}
            </div>
            @error('letter_issuer_name')
                <p class="text-danger">{{ $errors->first('letter_issuer_name') }}</p>
            @enderror
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Letter Issuer designation<span class="text-danger">*</span></label>
                {{ Form::text(
                    'letter_issuer_designation',
                    old('letter_issuer_designation') ? old('letter_issuer_designation') : '',
                    [
                        'class' => 'form-control',
                        'id' => 'letter_issuer_designation',
                        'placeholder' => 'Letter Issuer designation',
                    ],
                ) }}
            </div>
            @error('letter_issuer_designation')
                <p class="text-danger">{{ $errors->first('letter_issuer_designation') }}</p>
            @enderror
        </div>

        <div class="col-12 my-2">
            <div>
                <label class="input-group" for="name">Letter Carbon Copy To: <span class="text-danger">*</span> </label>
                <textarea name="letter_carbon_copy_to" id="letter_carbon_copy_to" cols="30" rows="2" class="mtl-summernote">{{ old('letter_carbon_copy_to') ? old('letter_carbon_copy_to') : '' }}</textarea>
            </div>
            @error('letter_carbon_copy_to')
                <p class="text-danger">{{ $errors->first('letter_carbon_copy_to') }}</p>
            @enderror
        </div>



    </div>

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
@section('script')
    <script></script>

@endsection



@if ($errors->any())
    <style>
        #validation-error-message-box {
            display: none !important;
        }
    </style>
@endif
