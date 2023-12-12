@extends('layouts.backend-layout')
@section('title', 'Unit')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Units
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('units.index') }}"><i
        class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/units', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/units/$unit->id",
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
            : (!empty($unit->name)
            ? $unit->name
            : null),
            ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter Name Here', 'required'],
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
            : (!empty($unit->bangla)
            ? $unit->bangla
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
                for="name">Short Name<span class="text-danger">*</span></label>
            {{ Form::text(
            'short_name',
            old('short_name')
            ? old('short_name')
            : (!empty($unit->short_name)
            ? $unit->short_name
            : null),
            ['class' => 'form-control', 'id' => 'short_name', 'placeholder' => 'Enter Short Name Here', 'required'],
            ) }}
            @error('short_name')
            <p class="text-danger">{{ $errors->first('short_name') }}</p>
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
            : (!empty($unit->status)
            ? $unit->status
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
