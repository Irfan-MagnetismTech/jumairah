@extends('layouts.backend-layout')
@section('title', 'Section')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Section
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('sections.index') }}"><i
        class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/sections', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/sections/$section->id",
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
                for="name">Section Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'name',
            old('name')
            ? old('name')
            : (!empty($section->name)
            ? $section->name
            : null),
            ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Section Name Here', 'required'],
            ) }}
            @error('name')
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Section Name Bangla<span class="text-danger">*</span></label>
            {{ Form::text(
            'section_name_bangla',
            old('section_name_bangla')
            ? old('section_name_bangla')
            : (!empty($section->section_name_bangla)
            ? $section->section_name_bangla
            : null),
            ['class' => 'form-control', 'id' => 'section_name_bangla', 'placeholder' => 'Enter section name bangla
            Here', 'required'],
            ) }}
            @error('section_name_bangla')
            <p class="text-danger">{{ $errors->first('section_name_bangla') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="company_name">Department<span class="text-danger">*</span></label>
            {{Form::select('department_id',$depertments, old('department_id') ? old('department_id') : (!empty($section)
            ? $section->department_id : null),['class' => 'form-control','id' => 'department_id', 'placeholder' =>
            'Select Department', 'required'] )}}
            @error('department_id') <p class="text-danger">{{ $errors->first('department_id') }}</p> @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Status<span class="text-danger">*</span></label>
            {{ Form::select(
            'status',
            [
            'Active' => 'Active',
            'Inactive' => 'Inactive',
            ],
            old('status')
            ? old('status')
            : (!empty($section->status)
            ? $section->status
            : null),
            ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status', 'required'],
            ) }}
            @error('status')
            <p class="text-danger">{{ $errors->first('status') }}</p>
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
