@extends('boq.departments.electrical.layout.app')
@section('title', 'Work Orders')

@section('breadcrumb-title')
    Terms and Conditions
@endsection

@section('breadcrumb-button')
        <a href="{{ url("boq/project/$project->id/departments/electrical/work_order/$workorder->id/edit") }}" data-toggle="tooltip" title="Edit Rate" class="btn btn-out-dashed btn-sm btn-info" data-toggle="tooltip" title="Edit Rate"><i class="fas fa-long-arrow-alt-left"></i></a>
        <a href="{{route("boq.project.departments.electrical.workorder.technical_specification", ['project' => $project ,'workorder' => $workorder->id]) }}" data-toggle="tooltip" title="Edit Technical Specification" class="btn btn-out-dashed btn-sm btn-info"><i class="fas fa-long-arrow-alt-right"></i></a>
        <a href="{{ url("boq/project/$project->id/departments/electrical/work_order") }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection


@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open(['url' => route('boq.project.departments.electrical.workorder.terms.store',['project' => $project,'workorder' => $workorder->id]), 'method' => 'POST', 'class' => 'custom-form']) !!}

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="workorder_no"> Work Order No. <span class="text-danger">*</span></label>
                {{ Form::text('workorder_no', $workorder->workorder_no, ['class' => 'form-control workorder_no', 'id' => 'workorder_no', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_no"> CS Ref No. <span class="text-danger">*</span></label>
                {{ Form::text('cs_no', $workorder->workCS->reference_no, ['class' => 'form-control cs_no', 'id' => 'cs_no', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_id">Supplier Name<span class="text-danger">*</span></label>
                {{ Form::text('supplier_id', $workorder->supplier->name, ['class' => 'form-control', 'id' => 'supplier_id', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
    </div>

    <hr class="bg-success">

    <div class="page-body border">
        <!-- Article Editor card start -->
        <div class="card">
            <div class="card-header">
                <h5>General Terms & Conditions </h5>
            </div>
            <div class="card-block">
                <textarea id="editor1" name="general_terms" style="visibility: hidden; display: none">{!! $workorder->terms->general_terms ?? null !!}</textarea>
            </div>
        </div>
        <!-- Article Editor card end -->
    </div>

    <div class="page-body border">
        <!-- Article Editor card start -->
        <div class="card">
            <div class="card-header">
                <h5>Payment Terms & Conditions </h5>
            </div>
            <div class="card-block">
                <textarea id="editor2" name="payment_terms" style="visibility: hidden; display: none"> {!! $workorder->terms->payment_terms ?? null !!} </textarea>
            </div>
        </div>
        <!-- Article Editor card end -->
    </div>


    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('script')
    <script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('js/ckeditor/ckeditor-custom.js')}}"></script>
@endsection
