@extends('layouts.backend-layout')
@section('title', 'Post Office')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Post Office
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('post-offices.index') }}"><i
        class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/post-offices', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/post-offices/$postOffice->id",
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
            : (!empty($postOffice->name)
            ? $postOffice->name
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
            : (!empty($postOffice->bangla)
            ? $postOffice->bangla
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
                for="name">District<span class="text-danger">*</span></label>
            {{ Form::select(
            'district_id',
            $districts,
            old('district_id')
            ? old('district_id')
            : (!empty($postOffice->district_id)
            ? $postOffice->district_id
            : null),
            ['class' => 'form-control', 'id' => 'district_id', 'placeholder' => 'Select district'],
            ) }}
            @error('district_id')
            <p class="text-danger">{{ $errors->first('district_id') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Police Station<span class="text-danger">*</span></label>
            {{ Form::select(
            'police_station_id',
            $policeStations,
            old('police_station_id')
            ? old('police_station_id')
            : (!empty($postOffice->police_station_id)
            ? $postOffice->police_station_id
            : null),
            ['class' => 'form-control', 'id' => 'police_station_id', 'placeholder' => 'Select Police Station'],
            ) }}
            @error('police_station_id')
            <p class="text-danger">{{ $errors->first('police_station_id') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                for="name">Post Code  <span class="text-danger">*</span></label>
            {{ Form::number(
            'post_code',
            old('post_code')
            ? old('post_code')
            : (!empty($postOffice->post_code)
            ? $postOffice->post_code
            : null),
            ['class' => 'form-control', 'id' => 'post_code', 'placeholder' => 'Enter Post Code Here', 'required'],
            ) }}
            @error('post_code')
            <p class="text-danger">{{ $errors->first('post_code') }}</p>
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
            : (!empty($postOffice->status)
            ? $postOffice->status
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
