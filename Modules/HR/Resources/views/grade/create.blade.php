@extends('layouts.backend-layout')
@section('title', 'Grade')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Grade
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('grades.index') }}"><i
        class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/grades', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/grades/$grade->id",
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
                for="name">Grade Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'name',
            old('name')
            ? old('name')
            : (!empty($grade)
            ? $grade->name
            : null),
            ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name Here', 'required'],
            ) }}
            @error('name')
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Bangla <span class="text-danger">*</span></label>
            {{ Form::text(
            'bangla',
            old('bangla')
            ? old('bangla')
            : (!empty($grade->bangla)
            ? $grade->bangla
            : null),
            ['class' => 'form-control', 'id' => 'bangla', 'placeholder' => 'Enter bangla Here', 'required'],
            ) }}
            @error('bangla')
            <p class="text-danger">{{ $errors->first('bangla') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Minimum GS <span class="text-danger">*</span></label>
            {{ Form::text(
            'minimum_gs',
            old('minimum_gs')
            ? old('minimum_gs')
            : (!empty($grade->minimum_gs)
            ? $grade->minimum_gs
            : null),
            ['class' => 'form-control', 'id' => 'minimum_gs', 'placeholder' => 'Enter Minimum GS Here', 'required'],
            ) }}
            @error('minimum_gs')
            <p class="text-danger">{{ $errors->first('minimum_gs') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Total Man Power <span class="text-danger">*</span></label>
            {{ Form::number(
            'total_manpower',
            old('total_manpower')
            ? old('total_manpower')
            : (!empty($grade->total_manpower)
            ? $grade->total_manpower
            : null),
            ['class' => 'form-control', 'id' => 'total_manpower', 'placeholder' => 'Enter Total Man Power Here', 'required'],
            ) }}
            @error('total_manpower')
            <p class="text-danger">{{ $errors->first('total_manpower') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Salary Range<span class="text-danger">*</span></label>
            {{ Form::text(
            'salary_range',
            old('salary_range')
            ? old('salary_range')
            : (!empty($grade->salary_range)
            ? $grade->salary_range
            : null),
            ['class' => 'form-control', 'id' => 'salary_range', 'placeholder' => 'Enter Salary Range Here', 'required'],
            ) }}
            @error('salary_range')
            <p class="text-danger">{{ $errors->first('salary_range') }}</p>
            @enderror
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
            : (!empty($floor->status)
            ? $floor->status
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
