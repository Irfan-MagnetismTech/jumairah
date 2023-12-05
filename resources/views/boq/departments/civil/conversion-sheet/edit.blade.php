@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Conversion Sheet')

@section('breadcrumb-title')
    Conversion Sheet
@endsection
@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.civil.conversion-sheets.index', ['project' => $project]) }}"
       class="btn btn-out-dashed btn-sm btn-warning">
        <i class="fas fa-database"></i>
    </a>
@endsection
@section('project-name')
    <a href="{{ route('boq.project.departments.civil.conversion-sheets.create', ['project' => $project]) }}"
       style="color:white;">{{ $project->name }}</a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.civil.conversion-sheets.update', ['project' => $project, 'conversion_sheet' => $conversion_data]) }}"
                  method="POST" class="custom-form">
                @method('PUT')
                @include('boq.departments.civil.conversion-sheet.form')
                @include('components.buttons.submit-button', ['label' => 'Update'])
            </form>
        </div>
    </div>
@endsection



{{--@extends('boq.departments.civil.layout.app')--}}
{{--@section('title', 'BOQ - Global Material Calculation List')--}}

{{--@section('breadcrumb-title')--}}
{{--    Revised sheet of Material--}}
{{--@endsection--}}
{{--@section('breadcrumb-button')--}}
{{--    <a href="{{ route('boq.project.global-material-specifications.index', ['project' => $project]) }}"--}}
{{--        class="btn btn-out-dashed btn-sm btn-warning">--}}
{{--        <i class="fas fa-database"></i>--}}
{{--    </a>--}}
{{--@endsection--}}
{{--@section('project-name')--}}
{{--    <a href="{{ route('boq.project.global-material-specifications.index', ['project' => $project]) }}"--}}
{{--        style="color:white;">{{ $project->name }}</a>--}}
{{--@endsection--}}

{{--@section('sub-title')--}}
{{--    <span class="text-danger">*</span> Marked are required.--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--    <br>--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-12">--}}
{{--            <form action="{{ route('boq.project.global-material-specifications.store', ['project' => $project]) }}"--}}
{{--                method="POST" class="custom-form">--}}
{{--                @include('boq.departments.civil.revised-sheet.form')--}}
{{--                @include('components.buttons.submit-button', ['label' => 'Submit'])--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
