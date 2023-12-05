@extends('layouts.backend-layout')
@section('title', 'IOU')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit IOU Slip
    @else
        Add IOU Slip
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('ious') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "ious/$iou->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        @php
            if($iou->type == 2){
                $work_order_id = $iou->workOrder->id;
                $work_order_no = $iou->workOrder->workorder_no;
            }elseif($iou->type == 3){
                $work_order_id = $iou->EmeWorkOrder->id;
                $work_order_no = $iou->EmeWorkOrder->workorder_no;
            }
        @endphp
    @else
        {!! Form::open(array('url' => "ious",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <input type="hidden" name="iou_id" value="{{(!empty($iou->id) ? $iou->id : null)}}">
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($iou) ? $iou->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($iou) ? $iou->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($iou->applied_date) ? $iou->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off", 'readonly'])}}
                </div>
            </div>

            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Note</label>
                    {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($iou->remarks) ? $iou->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Iou for<span class="text-danger">*</span></label>
                    <input type="radio" id="employee" class="employee" name="switch" value="employee" style="margin-left: 30px; margin-top: 8px" {{ ((isset($iou) && ($iou->type == 0)) ? 'checked' : "") }}>
                    <label  style="margin-left: 5px; margin-top: 7px" for="employee">Employee</label><br>
                    <input type="radio" id="suppliers" class="suppliers" value="supplier" name="switch" style="margin-left: 30px; margin-top: 8px" {{ ((isset($iou) && ($iou->type == 1)) ? 'checked' : "") }}>
                    <label  style="margin-left: 5px; margin-top: 7px" for="suppliers">Supplier</label><br>
                    <input type="radio" id="construction" class="construction" value="construction" name="switch" style="margin-left: 30px; margin-top: 8px" {{ ((isset($iou) && ($iou->type == 2)) ? 'checked' : "") }}>
                    <label  style="margin-left: 5px; margin-top: 7px" for="construction">Construction</label><br>
                    <input type="radio" id="eme" class="eme" value="eme" name="switch" style="margin-left: 30px; margin-top: 8px" {{ ((isset($iou) && ($iou->type == 3)) ? 'checked' : "") }}>
                    <label style="margin-left: 5px; margin-top: 7px" for="construction">Eme</label>
                </div>

                <div class="input-group input-group-sm input-group-primary supplier_name" style="{{ ((!empty($iou->supplier_id) || old('supplier_id')) ? '': "display:none") }}">
                    <label class="input-group-addon" for="supplier_name">Supplier Name<span class="text-danger">*</span></label>
                    {{Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($iou) ? $iou->supplier->name : null),['class' => 'form-control','id' => 'supplier_name','placeholder'=>"Search Supplier Name" ,'autocomplete'=>"off"])}}
                    {{Form::hidden('supplier_id', old('supplier_id') ? old('supplier_id') : (!empty($iou) ? $iou->supplier->id: null),['class' => 'form-control','id' => 'supplier_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary po_no" style="{{ ((!empty($iou->po_no) ||  old('po_no')) ? '': "display:none") }}">
                    <label class="input-group-addon" for="supplier_name">PO No.<span class="text-danger">*</span></label>
                    {{Form::text('po_no', old('po_no') ? old('po_no') : (!empty($iou->po_no) ? $iou->po_no : null),['class' => 'form-control','id' => 'po_no','placeholder'=>"Search PO No" ,'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary mpr_no" style="{{ ((!empty($iou->requisition_id) ||  old('mpr_no')) ? '': "display:none") }}">
                    <label class="input-group-addon" for="supplier_name">MPR No.</label>
                    {{Form::text('mpr_no', old('mpr_no') ? old('mpr_no') : (!empty($iou->requisition_id) ? $iou->mpr->mpr_no : null),['class' => 'form-control','id' => 'mpr_no','placeholder'=>"Search MPR No" ,'autocomplete'=>"off"])}}
                    {{Form::hidden('mpr_id', old('mpr_id') ? old('mpr_id') : (!empty($iou->requisition_id) ? $iou->requisition_id : null),['class' => 'form-control','id' => 'mpr_id','autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary work_order_no" style="{{ (!empty($iou->workorder_id) || !empty($iou->boq_eme_work_order_id) || old('workorder_id')) ? '' : "display:none" }}">
                    <label class="input-group-addon" for="supplier_name">Work Order No.<span class="text-danger">*</span></label>
                    {{Form::text('work_order_no', old('work_order_no') ? old('work_order_no') : ((!empty($iou->workorder_id) || !empty($iou->boq_eme_work_order_id)) ? $work_order_no : null),['class' => 'form-control','id' => 'work_order_no','placeholder'=>"Search Work Order No" ,'autocomplete'=>"off"])}}
                    {{Form::hidden('workorder_id', old('workorder_id') ? old('workorder_id') : ((!empty($iou->workorder_id) || !empty($iou->boq_eme_work_order_id)) ? $work_order_id : null),['class' => 'form-control','id' => 'workorder_id','autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive common_list" style="{{ (((isset($iou) && ($iou->type != 0)) || old('purpose')) ? '': "display:none") }}">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Purpose</th>
                <th>Amount<span class="text-danger">*</span></th>
                <th><button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button></th>
            </tr>
            </thead>
            <tbody>

            @if(old('purpose'))
                @foreach(old('purpose') as $key => $materialOldData)
                    <tr>
                        <td><input type="text" name="purpose[]" value="{{old('purpose')[$key]}}" class="form-control form-control-sm text-center supplier_purpose" autocomplete="off"></td>
                        <td><input type="number" name="amount[]" value="{{old('amount')[$key]}}" class="form-control form-control-sm text-center common_amount" min="0" step="0.01" placeholder="0.00" autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>

                    </tr>
                @endforeach
            @else
                @if(!empty($iou))
                    @foreach($iou->ioudetails as $ioudetail)
                        <tr>
                            <td><input type="text" name="purpose[]" value="{{($iou->type != 0) ? $ioudetail->purpose : null }}" class="form-control form-control-sm text-center supplier_purpose" autocomplete="off"></td>
                            <td><input type="number" name="amount[]" value="{{($iou->type != 0) ? $ioudetail->amount : null }}" class="form-control form-control-sm text-center common_amount" min="0" step="0.01" placeholder="0.00"  autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif


            </tbody>
            <tfoot>
            <tr>
                <td class="text-right">Total </td>
                <td>
                    {{Form::number('total_amount', old('total_amount') ? old('total_amount') :  ((isset($iou) && ($iou->type != 0)) ? $iou->total_amount: null),['class' => 'form-control form-control-sm text-center common_total_amount', 'id' => 'common_total_amount', 'tabindex'=>"-1", 'autocomplete'=>"off",'readonly','placeholder'=>"0.00",'tabindex'=>-1] )}}
                </td>
            </tr>
            </tfoot>
        </table>
    </div> <!-- end table responsive -->
    <div class="table-responsive employee_list" style="{{ (((isset($iou) && ($iou->type == 0)) || old('employee_purpose')) ? '': "display:none") }}">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTableEmployee">
            <thead>
                <tr>
                    <th width="500">Purpose<span class="text-danger">*</span></th>
                    <th width="500">Remarks</th>
                    <th width="500">Amount<span class="text-danger">*</span></th>
                    <th><button class="btn btn-success btn-sm addItemEmployee" type="button"><i class="fa fa-plus"></i></button></th>
                </tr>
            </thead>
            <tbody>

            @if(old('employee_purpose'))
                @foreach(old('employee_purpose') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="text" name="employee_purpose[]" value="{{old('employee_purpose')[$key]}}" class="form-control form-control-sm text-center employee_purpose" autocomplete="off">
                        </td>
                        <td>
                            <input type="text" name="employee_remarks[]" value="{{old('employee_remarks')[$key]}}" class="form-control form-control-sm text-center employee_remarks" autocomplete="off">
                        </td>
                        <td>
                            <input type="number" name="employee_amount[]" value="{{old('employee_amount')[$key]}}" class="form-control form-control-sm text-center employee_amount" min="0" step="0.01" placeholder="0.00"  autocomplete="off">
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm deleteItemEmployee" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                        </td>

                    </tr>
                @endforeach
            @else
                @if(!empty($iou))
                    @foreach($iou->ioudetails as $ioudetail)
                        <tr>
                            <td>
                                <input type="text" name="employee_purpose[]" value="{{($iou->type == 0) ? $ioudetail->purpose : null }}" class="form-control form-control-sm text-center employee_purpose" autocomplete="off">
                            </td>
                            <td><input type="text" name="employee_remarks[]" value="{{($iou->type == 0) ? $ioudetail->remarks : null }}" class="form-control form-control-sm text-center employee_remarks" autocomplete="off"></td>
                            <td><input type="number" name="employee_amount[]" value="{{($iou->type == 0) ? $ioudetail->amount : null }}" class="form-control form-control-sm text-center employee_amount" min="0" step="0.01" placeholder="0.00"  autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItemEmployee" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-right">Total </td>
                <td>
                    {{Form::number('employee_total_amount', old('employee_total_amount') ? old('employee_total_amount') : ((isset($iou) && ($iou->type == 0)) ? $iou->total_amount: null),['class' => 'form-control form-control-sm text-center employee_total_amount', 'id' => 'employee_total_amount', 'tabindex'=>"-1", 'autocomplete'=>"off",'readonly','placeholder'=>"0.00",'tabindex'=>-1] )}}
                </td>
            </tr>
            </tfoot>
        </table>
    </div> <!-- end table responsive -->

        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        const CSRF_TOKEN = "{{csrf_token()}}";

        // Function for adding material row
        function addRow(){
            let row = `
                <tr>
                    <td><input type="text" name="purpose[]" class="form-control form-control-sm text-center supplier_purpose" autocomplete="off"></td>
                    <td><input type="number" name="amount[]" class="form-control form-control-sm text-center common_amount" min="0"  placeholder="0.00"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            common_grand_total();
        }

        // Function for adding material row
        function addRowEmployee(){
            let row = `
                <tr>
                    <td><input type="text" name="employee_purpose[]" class="form-control form-control-sm text-center employee_purpose" autocomplete="off"></td>
                    <td><input type="text" name="employee_remarks[]" class="form-control form-control-sm text-center employee_remarks"  autocomplete="off"></td>
                    <td><input type="number" name="employee_amount[]" class="form-control form-control-sm text-center employee_amount" min="0"  placeholder="0.00"></td>
                    <td><button class="btn btn-danger btn-sm deleteItemEmployee" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTableEmployee tbody').append(row);
            employee_grand_total();
        }
        // Function for counting total amount
        function employee_grand_total(){
            let total = 0;
            if($(".employee_amount").length > 0){
                $(".employee_amount").each(function(){
                    var amount = $(this).val();
                    total += parseFloat(amount);
                })
            }
            $("#employee_total_amount").val(total);
        }

        function common_grand_total(){
            let total = 0;
            if($(".common_amount").length > 0){
                $(".common_amount").each(function(){
                    var amount1 = $(this).val();
                    total += parseFloat(amount1);
                })
            }
            $("#common_total_amount").val(total);
        }

        // Function for autocompletion of projects

        $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.costCenterAutoSuggest')}}",
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
                    $('#cost_center_id').val(ui.item.value);
                    $('#project_id').val(ui.item.project_id);
                    $('#project_name').val(ui.item.label);
                    $("#itemTable").find("tbody").children("tr").remove();
                    return false;
                }
            })

        // function for supplier name auto suggest

        $("#supplier_name").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "{{route('supplierAutoSuggest')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $('#supplier_name').val(ui.item.label);
                $('#supplier_id').val(ui.item.value);
                return false;
            }
        });
        $(document).on('keyup', "#work_order_no", function(){
            const radio_value = document.querySelector('input[name="switch"]:checked').value;
            let supplier = $('#supplier_id').val();
                if(supplier == null || supplier == ''){
                    alert('Please select a supplier');
                }else{
                    if(radio_value == 'construction'){
                        $('#workorder_id').val('');
                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: "{{ route('workOrderAutoSuggestForSuppliers') }}",
                                    type: 'post',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        search: request.term,
                                        supplier_id: supplier
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                $('#work_order_no').val(ui.item.label);
                                $('#workorder_id').val(ui.item.value);
                                return false;
                            }
                        });
                    }else{
                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: "{{ route('boqEmeWorkOrderAutoSuggestForSuppliers') }}",
                                    type: 'post',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        search: request.term,
                                        supplier_id: supplier
                                    },
                                    success: function(data) {
                                        response(data);
                                    }
                                });
                            },
                            select: function(event, ui) {
                                $('#work_order_no').val(ui.item.label);
                                $('#workorder_id').val(ui.item.value);
                                return false;
                            }
                        });
                    }
                }
        });


        $(document).on('keyup', "#po_no", function(){
                let supplier = $('#supplier_id').val();
                if(supplier == null || supplier == ''){
                    alert('Please select a supplier');
                }else{
                    $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('scj.SupplierWisePo')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                supplier_id: supplier
                            },
                            success: function( data ) {
                                if (data.length > 0) {
                                        response(data);
                                } else {
                                    response([{
                                        label: 'No results found.',
                                        val: -1,
                                        floor_id: null
                                    }]);
                                }
                            }
                        });
                    },
                    select: function (event, ui) {
                        if (ui.item.val == -1) {
                                $(this).val('');
                                return false;
                        }else{
                            $(this).val(ui.item.label);
                            return false;
                        }

                    }

                });
                    }
            });






        $('#applied_date').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            showOtherMonths: true
        });

        $("#itemTable").on('click', ".addItem", function(){
            addRow();
            common_grand_total();

        }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                common_grand_total();
        });

        $("#itemTableEmployee").on('click', ".addItemEmployee", function(){
            addRowEmployee();
            employee_grand_total();
        }).on('click', '.deleteItemEmployee', function(){
                $(this).closest('tr').remove();
                employee_grand_total();
        });
        $("#mpr_no").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('scj.mprAutoSuggest') }}",
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
                $('#mpr_no').val(ui.item.label);
                $('#mpr_id').val(ui.item.value);
                return false;
            }
        });


        $(function(){
            @if($formType == 'create' && !old('purpose'))
                addRow();
            @elseif($formType == 'create' && !old('employee_purpose'))
                addRowEmployee();
            @endif




            $(document).on('keyup mousewheel', ".common_amount", function(){
                common_grand_total();
            });
            $(document).on('keyup mousewheel', ".employee_amount", function(){
                employee_grand_total();
            });
        });

        $(document).ready(function(){
            $('#employee').click(function() {
                $('.common_list').hide("fade");
                $('.supplier_name').hide("fade");
                $('.po_no').hide("fade");
                $('.work_order_no').hide("fade");
                $('.employee_list').show("fade");
                $('.mpr_no').show("fade");
                $('#itemTableEmployee tbody').empty();
                addRowEmployee();
            });
        });
        $(document).ready(function(){
            $('#suppliers').click(function() {
                $('.employee_list').hide("fade");
                $('.supplier_name').show("fade");
                $('.po_no').show("fade");
                $('.work_order_no').hide("fade");
                $('.common_list').show("fade");
            });
        });
        $(document).ready(function(){
            $('#construction').click(function() {
                $('.employee_list').hide("fade");
                $('.supplier_name').show("fade");
                $('.work_order_no').show("fade");
                $('.po_no').hide("fade");
                $('.common_list').show("fade");
            });
        });
        $(document).ready(function(){
            $('#eme').click(function() {
                $('.employee_list').hide();
                $('.supplier_name').show("fade");
                $('.work_order_no').show("fade");
                $('.po_no').hide("fade");
                $('.common_list').show("fade");
            });
        });
    </script>
@endsection
