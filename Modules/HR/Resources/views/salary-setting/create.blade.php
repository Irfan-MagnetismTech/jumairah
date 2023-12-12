@extends('layouts.backend-layout')
@section('title', 'Salary Setting')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Salary Settings
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('salary-settings.index') }}"><i
        class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/salary-settings', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/salary-settings/$salarySetting->id",
'method' => 'PUT',
'class' => 'custom-form',
'files' => true,
'enctype'=>'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Employee Type<span class="text-danger">*</span></label>
            {{ Form::select(
            'employee_type_id',
            $employeeTypes,
            old('employee_type_id')
            ? old('employee_type_id')
            : (!empty($salarySetting->employee_type_id)
            ? $salarySetting->employee_type_id
            : null),
            ['class' => 'form-control', 'id' => 'employee_type_id', 'placeholder' => 'Select Employee Type'],
            ) }}
            @error('employee_type_id')
            <p class="text-danger">{{ $errors->first('employee_type_id') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Basic % <span class="text-danger">*</span></label>
            {{ Form::number(
            'basic',
            old('basic')
            ? old('basic')
            : (!empty($salarySetting->basic)
            ? $salarySetting->basic
            : null),
            ['class' => 'form-control', 'id' => 'basic', 'placeholder' => 'Enter basic Here', 'required'],
            ) }}
            @error('basic')
            <p class="text-danger">{{ $errors->first('basic') }}</p>
            @enderror
        </div>
    </div>



    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">House Rent % <span class="text-danger">*</span></label>
            {{ Form::number(
            'house_rent',
            old('house_rent')
            ? old('house_rent')
            : (!empty($salarySetting->house_rent)
            ? $salarySetting->house_rent
            : null),
            ['class' => 'form-control', 'id' => 'house_rent', 'placeholder' => 'Enter house rent Here', 'required'],
            ) }}
            @error('house_rent')
            <p class="text-danger">{{ $errors->first('house_rent') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Medical Allowance % <span class="text-danger">*</span></label>
            {{ Form::number(
            'medical_allowance',
            old('medical_allowance')
            ? old('medical_allowance')
            : (!empty($salarySetting->medical_allowance)
            ? $salarySetting->medical_allowance
            : null),
            ['class' => 'form-control', 'id' => 'medical_allowance', 'placeholder' => 'Enter medical allowance Here', 'required'],
            ) }}
            @error('medical_allowance')
            <p class="text-danger">{{ $errors->first('medical_allowance') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Conveyance Allowance % <span class="text-danger">*</span></label>
            {{ Form::number(
            'conveyance_allowance',
            old('conveyance_allowance')
            ? old('conveyance_allowance')
            : (!empty($salarySetting->conveyance_allowance)
            ? $salarySetting->conveyance_allowance
            : null),
            ['class' => 'form-control', 'id' => 'conveyance_allowance', 'placeholder' => 'Enter conveyance allowance Here', 'required'],
            ) }}
            @error('conveyance_allowance')
            <p class="text-danger">{{ $errors->first('conveyance_allowance') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Food Allowance % <span class="text-danger">*</span></label>
            {{ Form::number(
            'food_allowance',
            old('food_allowance')
            ? old('food_allowance')
            : (!empty($salarySetting->food_allowance)
            ? $salarySetting->food_allowance
            : null),
            ['class' => 'form-control', 'id' => 'food_allowance', 'placeholder' => 'Enter food allowance Here', 'required'],
            ) }}
            @error('food_allowance')
            <p class="text-danger">{{ $errors->first('food_allowance') }}</p>
            @enderror
        </div>
    </div>

</div><!-- end row -->

<div class="row">
    <div class="offset-md-4 col-md-4 mt-2 ">
        <div class="input-group input-group-sm ">
            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
        </div>
    </div>
</div> <!-- end row -->
{!! Form::close() !!}
@endsection
@section('script')
<script></script>

@endsection
