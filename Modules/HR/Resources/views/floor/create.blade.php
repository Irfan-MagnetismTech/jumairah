@extends('layouts.backend-layout')
@section('title', 'Floors')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
floor
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('floors.index') }}"><i
        class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/floors', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/floors/$floor->id",
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
                for="name">Building Name<span class="text-danger">*</span></label>
            {{Form::select('building_info_id',$buildingInfos, old('building_info_id') ? old('building_info_id') : (!empty($floor)
            ? $floor->building_info_id : null),['class' => 'form-control','id' => 'building_info_id', 'placeholder' =>
            'Select Building Info', 'required'] )}}
            @error('building_info_id')
            <p class="text-danger">{{ $errors->first('building_info_id') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Floor Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'name',
            old('name')
            ? old('name')
            : (!empty($floor->name)
            ? $floor->name
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
            : (!empty($floor->bangla)
            ? $floor->bangla
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
        <di   v    cl   ass=    "input-group input-group-sm ">
            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
        </div>
    </div>
</div> <!-- end row -->
{!! Form::close() !!}
@endsection
@section('script')
<script></script>

@endsection
