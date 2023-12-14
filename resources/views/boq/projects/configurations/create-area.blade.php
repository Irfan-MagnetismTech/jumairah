@extends('boq.layout.app')
@section('title', 'BOQ - Area and floor configuration')
@section('project-name', $project->name)

@section('breadcrumb-title')
    Floor Area configuration
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.configurations.areas.store', ['project' => $project]) }}" enctype="multipart/form-data" method="POST" class="custom-form">
                @include('boq.projects.configurations.buildup-form')
            </form>
        </div>
    </div>
@endsection
