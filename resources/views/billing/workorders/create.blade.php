@extends('layouts.backend-layout')
@section('title', 'Work Orders')

@section('breadcrumb-title')
    {{ empty($workorder) ? 'New Work Order' : 'Edit Work Order' }}
@endsection

@section('breadcrumb-button')
@if ($formType == 'edit')
    <a href="{{route("workorder-payments", $workorder->id)}}" data-toggle="tooltip" title="Payment Schedule" class="btn btn-out-dashed btn-sm btn-info"><i class="fas fa-long-arrow-alt-right"></i></a>
@endif
    <a href="{{ url('workorders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
    {!! Form::open(['url' => empty($workorder) ? route('workorders.store') : route('workorders.update', $workorder->id), 'method' => empty($workorder) ? 'POST' : 'PUT', 'class' => 'custom-form']) !!}

    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="issue_date">Issue Date<span class="text-danger">*</span></label>
                {{ Form::text('issue_date', old('issue_date', $workorder->issue_date ?? null), ['class' => 'form-control', 'id' => 'issue_date', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="workorder_no"> Work Order No. <span class="text-danger">*</span></label>
                {{ Form::text('workorder_no', old('workorder_no', $workorder->workorder_no ?? null), ['class' => 'form-control workorder_no', 'id' => 'workorder_no', 'required']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="deadline"> Deadline <span class="text-danger">*</span></label>
                {{ Form::text('deadline', old('deadline', $workorder->deadline ?? null), ['class' => 'form-control deadline', 'id' => 'deadline', 'required','readonly']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_no"> CS Ref No. <span class="text-danger">*</span></label>
                {{ Form::text('cs_no', old('cs_no', $workorder->workCS->reference_no ?? null), ['class' => 'form-control cs_no', 'id' => 'cs_no', 'required']) }}
                {{ Form::hidden('work_cs_id', old('work_cs_id', $workorder->work_cs_id ?? null), ['class' => 'form-control work_cs_id', 'id' => 'work_cs_id','required']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_id">Supplier Name<span class="text-danger">*</span></label>
                {{ Form::select('supplier_id', $suppliers, null, ['class' => 'form-control', 'id' => 'supplier_id', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
    </div>

    <hr class="bg-success">

    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_type">CS Type <span class="text-danger">*</span></label>
                {{ Form::text('cs_type', old('cs_type', $workorder->workCS->cs_type ?? null), ['class' => 'form-control', 'id' => 'cs_type', 'readonly', 'required']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id"> Project Name <span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name', $workorder->workCS->project->name?? null), ['class' => 'form-control', 'id' => 'project_name', 'readonly', 'required']) }}
                {{ Form::hidden('project_id', old('project_id', $workorder->workCS->project_id?? null), ['class' => 'form-control', 'id' => 'project_id', 'readonly', 'required']) }}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="mt-1 col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="description"> Description </label>
                {{ Form::textarea('description', old('description', $workorder->description ?? null), ['class' => 'form-control', 'id' => 'description', 'autocomplete' => 'off', 'placeholder' => 'Description of Work', 'rows' => 2]) }}
            </div>
        </div>
        
        <div class="mt-1 col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="involvement"> Involvement </label>
                {{ Form::textarea('involvement', old('involvement', $workorder->involvement ?? null), ['class' => 'form-control', 'id' => 'involvement', 'autocomplete' => 'off', 'placeholder' => 'Involvement status in this work', 'rows' => 2]) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks"> Remarks</label>
                {{ Form::textarea('remarks', old('remarks', $workorder->remarks ?? null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => 2, 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>

    <hr class="bg-success">
    <div class="card">
        <div class="tableHeading">
            <h5> <span>&#10070;</span> Rate Schedule (R. S.) <span>&#10070;</span> </h5>
        </div>
        <div class="card-body p-1">
            <div class="table-responsive">
                <table id="rateScheduleTable" class="table text-center table-striped table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Level of Work<span class="text-danger">*</span></th>
                            <th>Description<span class="text-danger">*</span></th>
                            <th>Apprx Qty</th>
                            <th>Unit</th>
                            <th>Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($workorder))
                            @foreach ($workorder->workorderRates as $workorderRate)
                                <tr>
                                    <td> {{$loop->iteration}} </td>
                                    <td>
                                        <input type="text" name="work_level[]" value="{{$workorderRate->work_level}}" class="form-control form-control-sm work_level" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <textarea name="work_description[]" class="form-control form-control-sm work_description" rows=2 required>{{$workorderRate->work_description}}</textarea>
                                    </td>                    
                                    <td> <input type="number" name="work_quantity[]" value="{{$workorderRate->work_quantity}}" class="form-control text-right work_quantity" step="0.01" readonly required/> </td>
                                    <td>
                                        <input type="text" name="work_unit[]" value="{{$workorderRate->work_unit}}" class="form-control form-control-sm text-left work_unit" readonly autocomplete="off" required>
                                    </td>
                                    <td>
                                        <input type="text" name="work_rate[]" value="{{$workorderRate->work_rate}}" class="form-control form-control-sm text-right work_rate" readonly autocomplete="off" required>
                                    </td>
                                </tr>                            
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
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
                const url = '{{ url('loadWorkCsSupplier') }}/' + cs_supplier;
                let dropdown = $('#supplier_id');
                let oldSelectedItem = "{{ old('supplier_id', $workorder->supplier_id ?? '') }}";
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
        // Function for getting CS supplier
        function getCsRates() {
            const cs_id = $("#work_cs_id").val();
            const cs_supplier = $("#supplier_id").val();            

            if (cs_id && cs_supplier) {
                const url = '{{ url('loadWorkCsRates') }}/' + cs_id +'/'+ cs_supplier;
                let table = $('#rateScheduleTable tbody');
                table.empty();
                $.getJSON(url, function(items) {
                    $.each(items, function(key, rate) {
                        let tr = `
                            <tr>
                                <td> ${key+1} </td>
                                <td>
                                    <input type="text" name="work_level[]" value="${rate.work_level}" class="form-control form-control-sm work_level" autocomplete="off" required>
                                </td>
                                <td>
                                    <textarea name="work_description[]" class="form-control form-control-sm work_description" rows=2 required>${rate.work_desciption}</textarea>
                                </td>                    
                                <td> <input type="number" name="work_quantity[]" value="${rate.work_quantity}" class="form-control text-right work_quantity" step="0.01" readonly required/> </td>
                                <td>
                                    <input type="text" name="work_unit[]" value="${rate.work_unit}" class="form-control form-control-sm text-left work_unit" readonly autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="work_rate[]" value="${rate.work_price}" class="form-control form-control-sm text-right work_rate" readonly autocomplete="off" required>
                                </td>
                            </tr>
                        `;
                        table.append(tr);
                    }); 
                });
            }else{
                alert("Please select Supplier ID"); 
            }
        }



        // Function for autocompletion of cs_no
        $("#cs_no").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('workCSRefAutoSuggest') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#cs_no').val(ui.item.label);
                $('#work_cs_id').val(ui.item.value);
                if(ui.item.is_for_all == 0){
                    $('#project_name').attr('readonly',true);
                    $('#project_name').val(ui.item.project_name);
                    $('#project_id').val(ui.item.project_id);
                }else{
                    $('#project_name').attr('readonly',false);
                }
                $('#cs_type').val(ui.item.cs_type);
                $('#description').val(ui.item.description);
                $('#involvement').val(ui.item.involvement);
                getCsSupplier();
                return false;
            }
        });
        // Date picker formatter
        $('#issue_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
        $('#deadline').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });
        $( "#project_name").autocomplete({
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
            })
        $(function() {
            @if(!empty($workorder) || old()) getCsSupplier(); @endif 

            $("#supplier_id").on('change', function(){
                getCsRates(); 
            }); 
        }) // Document.Ready

       

        $(document).ready(function(){
            const oldcss = localStorage.getItem('sstt');
            $('#mCSB_1_container').css("top",oldcss);
            setTimeout(() => {
                const oldcss = localStorage.getItem('sstt');
            $('#mCSB_1_container').css("top",oldcss);
  }, 5000)
        })
        $(window).load(function() {
            const oldcss = localStorage.getItem('sstt');
            $('#mCSB_1_container').css("top",oldcss);
        });

        $(document).on('mousemove',function(){
       
       const newcss = $('#mCSB_1_container').css("top");
       localStorage.setItem("sstt", newcss);
        })
    </script>
@endsection
