@extends('layouts.backend-layout')
@section('title', 'Designation')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Designation
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('designations.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/designations',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/designations/$designation->id",
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
                {{ Form::text('name', old('name') ? old('name') : (!empty($designation->name) ? $designation->name : null), [
                    'class' => 'form-control',
                    'id' => 'name',
                    'placeholder' => 'Enter name Here',
                    'required',
                ]) }}
                @error('name')
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Bangla </label>
                {{ Form::text(
                    'bangla',
                    old('bangla') ? old('bangla') : (!empty($designation->bangla) ? $designation->bangla : null),
                    ['class' => 'form-control', 'id' => 'bangla', 'placeholder' => 'Enter bangla Here'],
                ) }}
                @error('bangla')
                    <p class="text-danger">{{ $errors->first('bangla') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Attendance Bonus </label>
                {{ Form::text(
                    'attendance_bonus',
                    old('attendance_bonus')
                        ? old('attendance_bonus')
                        : (!empty($designation->attendance_bonus)
                            ? $designation->attendance_bonus
                            : null),
                    ['class' => 'form-control', 'id' => 'attendance_bonus', 'placeholder' => 'Enter Attendance Bonus Here'],
                ) }}
                @error('attendance_bonus')
                    <p class="text-danger">{{ $errors->first('attendance_bonus') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Holiday Bonus </label>
                {{ Form::text(
                    'holiday_bonus',
                    old('holiday_bonus')
                        ? old('holiday_bonus')
                        : (!empty($designation->holiday_bonus)
                            ? $designation->holiday_bonus
                            : null),
                    ['class' => 'form-control', 'id' => 'bangla', 'placeholder' => 'Enter holiday bonus Here'],
                ) }}
                @error('holiday_bonus')
                    <p class="text-danger">{{ $errors->first('holiday_bonus') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Night Shift Allowance </label>
                {{ Form::number(
                    'night_shift_allowance',
                    old('night_shift_allowance')
                        ? old('night_shift_allowance')
                        : (!empty($designation->night_shift_allowance)
                            ? $designation->night_shift_allowance
                            : null),
                    [
                        'class' => 'form-control',
                        'id' => 'night_shift_allowance',
                        'placeholder' => 'Enter Night Shift Allowance Here',
                    ],
                ) }}
                @error('night_shift_allowance')
                    <p class="text-danger">{{ $errors->first('night_shift_allowance') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">SI Number </label>
                {{ Form::number(
                    'SI_no',
                    old('SI_no') ? old('SI_no') : (!empty($designation->SI_no) ? $designation->SI_no : null),
                    ['class' => 'form-control', 'id' => 'SI_no', 'placeholder' => 'Enter SI NO Here'],
                ) }}
                @error('SI_no')
                    <p class="text-danger">{{ $errors->first('SI_no') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Grade </label>
                {{ Form::select(
                    'grade_id',
                    $grades,
                    old('grade_id') ? old('grade_id') : (!empty($designation->grade_id) ? $designation->grade_id : null),
                    ['class' => 'form-control', 'id' => 'grade_id', 'placeholder' => 'Select Grade Name'],
                ) }}
                @error('grade_id')
                    <p class="text-danger">{{ $errors->first('grade_id') }}</p>
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
                    old('status') ? old('status') : (!empty($designation->status) ? $designation->status : null),
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
