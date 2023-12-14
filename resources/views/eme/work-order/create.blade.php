@extends('layouts.backend-layout')
@section('title', 'BOQ - Work Order')

@section('breadcrumb-title')
    {{ empty($work_order) ? 'New Work Order' : 'Edit Work Order' }}
@endsection

@section('breadcrumb-button')
    @if ($formType == 'edit')
        <a href="{{route("eme.workorder.terms", ['workorder' => $work_order->id])}}" class="btn btn-out-dashed btn-sm btn-info" data-toggle="tooltip" title="Edit Terms"><i class="fas fa-long-arrow-alt-right"></i></a>
    @endif
    <a href="{{ url("eme/work_order") }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('style')
<style>
    #rateScheduleTable th:nth-child(6), #rateScheduleTable th:nth-child(4), #rateScheduleTable th:nth-child(5){
        width: 130px;
    }
</style>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open(['url' => empty($work_order) ? route('eme.work_order.store') : route('eme.work_order.update',['work_order' => $work_order->id]), 'method' => empty($work_order) ? 'POST' : 'PUT', 'class' => 'custom-form']) !!}

    <div class="row">
        <div class="col-md-4 col-xl-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name</label>
                {{Form::text('project_name',old('project_name') ? old('project_name') : (!empty($utility_bill) ? $utility_bill->project->name : null),['class' => 'form-control','id' => 'project_name', 'placeholder'=>"Search Project Name", 'autocomplete'=>"off"])}}
                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($utility_bill) ? $utility_bill->project_id  : null),['class' => 'form-control','id' => 'project_id','autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="issue_date">Issue Date<span class="text-danger">*</span></label>
                {{ Form::text('issue_date', old('issue_date', $work_order->issue_date ?? null), ['class' => 'form-control', 'id' => 'issue_date', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="workorder_no"> Work Order No. <span class="text-danger">*</span></label>
                {{ Form::text('workorder_no', old('workorder_no', $work_order->workorder_no ?? null), ['class' => 'form-control workorder_no', 'id' => 'workorder_no', 'required']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="deadline"> Deadline <span class="text-danger">*</span></label>
                {{ Form::text('deadline', old('deadline', $work_order->deadline ?? null), ['class' => 'form-control deadline', 'id' => 'deadline', 'required']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_no"> CS Ref No. <span class="text-danger">*</span></label>
                {{ Form::text('cs_no', old('cs_no', $work_order->workCS->reference_no ?? null), ['class' => 'form-control cs_no', 'id' => 'cs_no', 'required']) }}
                {{ Form::hidden('boq_eme_cs_id', old('boq_eme_cs_id', $work_order->boq_eme_cs_id ?? null), ['class' => 'form-control work_cs_id', 'id' => 'work_cs_id','required']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_id">Supplier Name<span class="text-danger">*</span></label>
                {{ Form::select('supplier_id', $suppliers=[], null, ['class' => 'form-control', 'id' => 'supplier_id', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
    </div>

    <hr class="bg-success">

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="workorder_for">Work Order For <span class="text-danger">*</span></label>
                {{ Form::text('workorder_for', old('workorder_for', $work_order->workorder_for ?? null), ['class' => 'form-control', 'id' => 'workorder_for', 'required']) }}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="mt-1 col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="description"> Description </label>
                {{ Form::textarea('description', old('description', $work_order->description ?? null), ['class' => 'form-control', 'id' => 'description', 'autocomplete' => 'off', 'placeholder' => 'Description of Work', 'rows' => 2]) }}
            </div>
        </div>

        <div class="mt-1 col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="involvement"> Involvement </label>
                {{ Form::textarea('involvement', old('involvement', $work_order->involvement ?? null), ['class' => 'form-control', 'id' => 'involvement', 'autocomplete' => 'off', 'placeholder' => 'Involvement status in this work', 'rows' => 2]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks"> Remarks</label>
                {{ Form::textarea('remarks', old('remarks', $work_order->remarks ?? null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => 2, 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>

    <hr class="bg-success">
    <div class="card">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Rate Schedule (R. S.) <span>&#10070;</span> </h5>
        </div>
        <div class="card-body p-1">
            <div class="card-block">
                <textarea id="editor1" name="workrate" style="visibility: hidden; display: none">{!! $work_order->workrate ?? null !!}</textarea>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="total_amount">Total Amount<span class="text-danger">*</span></label>
            {{ Form::text('total_amount', old('total_amount', $work_order->total_amount ?? null), ['class' => 'form-control total_amount', 'id' => 'total_amount', 'required','placeholder' => 'Total Amount']) }}
        </div>
    </div>
    <hr class="bg-success">
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
    <script>

        const CSRF_TOKEN = "{{ csrf_token() }}";

        // Function for getting CS supplier
        function getCsSupplier() {
            const cs_supplier = $("#work_cs_id").val();

            if (cs_supplier != '') {
                const url = "{{ url('eme/workorder/loadWorkCsSupplier') }}/" + cs_supplier;
                let dropdown = $('#supplier_id');
                let oldSelectedItem = "{{ old('supplier_id', $work_order->supplier_id ?? '') }}";
                console.log(oldSelectedItem);

                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Supplier </option>');
                dropdown.prop('selectedIndex', 0);

                $.getJSON(url, function(items) {
                    $.each(items, function(key, cs_supplier) {
                        let select = (oldSelectedItem == cs_supplier.supplier_id) ? "selected" : null;
                        let options =
                            `<option value="${cs_supplier.supplier_id}" ${select}>${cs_supplier.supplier.name}</option>`;
                        dropdown.append(options);
                    })
                });
            }
        }

        $(function() {
                     $("#project_name").autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('projectAutoSuggest')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#project_name').val(ui.item.label);
                        $('#project_id').val(ui.item.value);
                        return false;
                    }
                });
            });

        // Function for autocompletion of cs_no
        $("#cs_no").on('keyup change',function(events){
            let project_id = $('#project_id').val();
            $(this).autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{route('eme.workorder.workCSRefAutoSuggest')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term,
                        project_id
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#cs_no').val(ui.item.label);
                $('#work_cs_id').val(ui.item.value);
                getCsSupplier();
                return false;
            }
        });
        })
       

        // Date picker formatter
        $('#issue_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });

        $(function() {
            @if(!empty($work_order) || old()) getCsSupplier(); @endif


        }) // Document.Ready
    </script>
@endsection
