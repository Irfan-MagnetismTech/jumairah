@extends('layouts.backend-layout')
@section('title', 'Job Location')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Job Location
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('job-locations.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/job-locations',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/job-locations/$jobLocation->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Location Name <span class="text-danger">*</span></label>
                {{ Form::text('name', old('name') ? old('name') : (!empty($jobLocation->name) ? $jobLocation->name : null), [
                    'class' => 'form-control',
                    'id' => 'name',
                    'placeholder' => 'Enter location name Here',
                    'required',
                ]) }}
                @error('name')
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12 my-2">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="details">Job Location Details </label>
                {{ Form::textarea('details', old('details') ? old('details') : (!empty($jobLocation->details) ? $jobLocation->details : null), [
                    'class' => 'form-control',
                    'id' => 'details',
                    'placeholder' => 'Enter location details Here',
                ]) }}
            </div>
            @error('details')
                <p class="text-danger">{{ $errors->first('details') }}</p>
            @enderror
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
