@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Revised Sheet')

@section('breadcrumb-title')
    Revised Sheet
@endsection
@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.revised-sheets.index', ['project' => $project]) }}"
        class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.revised-sheets.create', ['project' => $project]) }}"
        style="color:white;">{{ $project->name }}</a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.revised-sheets.store', ['project' => $project]) }}"
                method="POST" class="custom-form">
                @include('boq.departments.civil.revised-sheet.form')
                @include('components.buttons.submit-button', ['label' => 'Submit'])
            </form>
        </div>
    </div>
@endsection



{{-- @extends('boq.departments.civil.layout.app') --}}
{{-- @section('title', 'BOQ - Global Material Calculation List') --}}

{{-- @section('breadcrumb-title') --}}
{{--    Revised sheet of Material --}}
{{-- @endsection --}}
{{-- @section('breadcrumb-button') --}}
{{--    <a href="{{ route('boq.project.global-material-specifications.index', ['project' => $project]) }}" --}}
{{--        class="btn btn-out-dashed btn-sm btn-warning"> --}}
{{--        <i class="fas fa-database"></i> --}}
{{--    </a> --}}
{{-- @endsection --}}
{{-- @section('project-name') --}}
{{--    <a href="{{ route('boq.project.global-material-specifications.index', ['project' => $project]) }}" --}}
{{--        style="color:white;">{{ $project->name }}</a> --}}
{{-- @endsection --}}

{{-- @section('sub-title') --}}
{{--    <span class="text-danger">*</span> Marked are required. --}}
{{-- @endsection --}}

{{-- @section('content') --}}
{{--    <br> --}}
{{--    <div class="row"> --}}
{{--        <div class="col-md-12"> --}}
{{--            <form action="{{ route('boq.project.global-material-specifications.store', ['project' => $project]) }}" --}}
{{--                method="POST" class="custom-form"> --}}
{{--                @include('boq.departments.civil.revised-sheet.form') --}}
{{--                @include('components.buttons.submit-button', ['label' => 'Submit']) --}}
{{--            </form> --}}
{{--        </div> --}}
{{--    </div> --}}
{{-- @endsection --}}
