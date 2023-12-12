@extends('layouts.backend-layout')
@section('title', 'Police Station')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Police Station
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('police-stations.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/police-stations',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/police-stations/$policeStation->id",
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
                    for="name">Name <span class="text-danger">*</span></label>
                {{ Form::text(
                    'name',
                    old('name') ? old('name') : (!empty($policeStation->name) ? $policeStation->name : null),
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
                    for="name">Bangla</label>
                {{ Form::text(
                    'bangla',
                    old('bangla') ? old('bangla') : (!empty($policeStation->bangla) ? $policeStation->bangla : null),
                    ['class' => 'form-control', 'id' => 'bangla', 'placeholder' => 'Enter bangla Here'],
                ) }}
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">District<span class="text-danger">*</span></label>
                {{ Form::select(
                    'district_id',
                    $districts,
                    old('district_id') ? old('district_id') : (!empty($policeStation->district_id) ? $policeStation->district_id : null),
                    ['class' => 'form-control', 'id' => 'district_id', 'placeholder' => 'Select district', 'required'],
                ) }}
                @error('district_id')
                    <p class="text-danger">{{ $errors->first('district_id') }}</p>
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
                    old('status') ? old('status') : (!empty($policeStation->status) ? $policeStation->status : 'Active'),
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
