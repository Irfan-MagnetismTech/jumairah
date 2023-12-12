@extends('layouts.backend-layout')
@section('title', 'Shift')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Shift
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('shifts.index') }}"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/shifts', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/shifts/$shift->id",
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
                for="name">Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'name',
            old('name')
            ? old('name')
            : (!empty($shift->name)
            ? $shift->name
            : null),
            ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Shift name Here', 'required'],
            ) }}
            @error('name')
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>
    </div>


    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Code</label>
            {{ Form::text(
            'code',
            old('code')
            ? old('code')
            : (!empty($shift->code)
            ? $shift->code
            : null),
            ['class' => 'form-control', 'id' => 'code', 'placeholder' => 'Enter Code Here'],
            ) }}
            @error('code')
            <p class="text-danger">{{ $errors->first('code') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Description</label>
            {{ Form::textarea(
            'description',
            old('description')
            ? old('description')
            : (!empty($shift->description)
            ? $shift->description
            : null),
            ['class' => 'form-control', 'id' => 'description','rows' => 5, 'cols' => 40, 'placeholder' => 'Enter Description Name Here'],
            ) }}
            @error('description')
            <p class="text-danger">{{ $errors->first('description') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="shift_in">Shift In<span class="text-danger">*</span></label>
            {{ Form::time(
            'shift_in',
            old('shift_in')
            ? old('shift_in')
            : (!empty($shift->shift_in)
            ? $shift->shift_in
            : null),
            ['class' => 'form-control', 'id' => 'shift_in', 'placeholder' => 'Enter Shift In Here', 'required'],
            ) }}
            @error('shift_in')
            <p class="text-danger">{{ $errors->first('shift_in') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="shift_out">Shift Out<span class="text-danger">*</span></label>
            {{ Form::time(
            'shift_out',
            old('shift_out')
            ? old('shift_out')
            : (!empty($shift->shift_out)
            ? $shift->shift_out
            : null),
            ['class' => 'form-control', 'id' => 'shift_out', 'placeholder' => 'Enter Shift Out Here', 'required'],
            ) }}
            @error('shift_out')
            <p class="text-danger">{{ $errors->first('shift_out') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Shift Late</label>

            {{ Form::time( 'shift_late', old('shift_late') ? old('shift_late') : (!empty($shift->shift_late) ?
            $shift->shift_late : null), ['class' => 'form-control', 'id' => 'shift_late', 'placeholder' => 'Enter Shift
            Late Here'], ) }}
            @error('shift_late')
            <p class="text-danger">{{ $errors->first('shift_late') }}</p>
            @enderror

        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Lunch Time</label>
            {{ Form::time( 'lunch_time', old('lunch_time') ? old('lunch_time') : (!empty($shift->lunch_time) ?
            $shift->lunch_time : null), ['class' => 'form-control', 'id' => 'lunch_time', 'placeholder' => 'Enter Lunch
            Time Here'], ) }}
            @error('lunch_time')
            <p class="text-danger">{{ $errors->first('lunch_time') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Lunch In</label>
            {{ Form::time( 'lunch_in', old('lunch_in') ? old('lunch_in') : (!empty($shift->lunch_in) ?
            $shift->lunch_in : null), ['class' => 'form-control', 'id' => 'lunch_in', 'placeholder' => 'Enter Lunch In Here'], ) }}
            @error('lunch_in')
            <p class="text-danger">{{ $errors->first('lunch_in') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Lunch Out</label>
            {{ Form::time( 'lunch_out', old('lunch_out') ? old('lunch_out') : (!empty($shift->lunch_out) ?
            $shift->lunch_out : null), ['class' => 'form-control', 'id' => 'lunch_out', 'placeholder' => 'Enter Lunch Out
            Here'], ) }}
            @error('lunch_out')
            <p class="text-danger">{{ $errors->first('lunch_out') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Regular Hour</label>
            {{ Form::time( 'regular_hour', old('regular_hour') ? old('regular_hour') : (!empty($shift->regular_hour) ?
            $shift->regular_hour : null), ['class' => 'form-control', 'id' => 'regular_hour', 'placeholder' => 'Enter
            Regular Hour Here'], ) }}
            @error('regular_hour')
            <p class="text-danger">{{ $errors->first('regular_hour') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Tiffin Time</label>
            {{ Form::time( 'tiffin_time', old('tiffin_time') ? old('tiffin_time') : (!empty($shift->tiffin_time) ?
            $shift->tiffin_time : null), ['class' => 'form-control', 'id' => 'tiffin_time', 'placeholder' => 'Enter Tiffin
            Time Here'], ) }}
            @error('tiffin_time')
            <p class="text-danger">{{ $errors->first('tiffin_time') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Tiffin In</label>
            {{ Form::time( 'tiffin_in', old('tiffin_in') ? old('tiffin_in') : (!empty($shift->tiffin_in) ?
            $shift->tiffin_in : null), ['class' => 'form-control', 'id' => 'tiffin_in', 'placeholder' => 'Enter Tiffin In
            Here'], ) }}
            @error('tiffin_in')
            <p class="text-danger">{{ $errors->first('tiffin_in') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Tiffin Time 2 </label>
            {{ Form::time( 'tiffin_time_2', old('tiffin_time_2') ? old('tiffin_time_2') : (!empty($shift->tiffin_time_2) ?
            $shift->tiffin_time_2 : null), ['class' => 'form-control', 'id' => 'tiffin_time_2', 'placeholder' => 'Enter
            Tiffin Time 2 Here'], ) }}
            @error('tiffin_time_2')
            <p class="text-danger">{{ $errors->first('tiffin_time_2') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 50% !important; max-width:50% !important;" class="input-group-addon"
                for="name">Tiffin Time 2 In</label>
            {{ Form::time( 'tiffin_time_2_in', old('tiffin_time_2_in') ? old('tiffin_time_2_in') : (!empty($shift->tiffin_time_2_in) ?
            $shift->tiffin_time_2_in : null), ['class' => 'form-control', 'id' => 'tiffin_time_2_in', 'placeholder' => 'Enter
            Tiffin Time 2 In Here'], ) }}
            @error('tiffin_time_2_in')
            <p class="text-danger">{{ $errors->first('tiffin_time_2_in') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 50% !important; max-width:50% !important;" class="input-group-addon"
                for="name">Tiffin Time 2 Out</label>
            {{ Form::time( 'tiffin_time_2_out', old('tiffin_time_2_out') ? old('tiffin_time_2_out') : (!empty($shift->tiffin_time_2_out) ?
            $shift->tiffin_time_2_out : null), ['class' => 'form-control', 'id' => 'tiffin_time_2_out', 'placeholder' => 'Enter
            Tiffin Time 2 Out Here'], ) }}
            @error('tiffin_time_2_out')
            <p class="text-danger">{{ $errors->first('tiffin_time_2_out') }}</p>
            @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-4">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 50% !important; max-width:50% !important;" class="input-group-addon"
                for="name">Tiffin Out</label>
            {{ Form::time( 'tiffin_out', old('tiffin_out') ? old('tiffin_out') : (!empty($shift->tiffin_out) ?
            $shift->tiffin_out : null), ['class' => 'form-control', 'id' => 'tiffin_out', 'placeholder' => 'Enter Tiffin
            Out Here'], ) }}
            @error('tiffin_out')
            <p class="text-danger">{{ $errors->first('tiffin_out') }}</p>
            @enderror
        </div>
    </div>


    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Status</label>
            {{ Form::select(
            'status',
            [
            'Active' => 'Active',
            'Inactive' => 'Inactive',
            ],
            old('status')
            ? old('status')
            : (!empty($shift->status)
            ? $shift->status
            : null),
            ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status'],
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
