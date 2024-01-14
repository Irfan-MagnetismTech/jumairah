@extends('layouts.backend-layout')
@section('title', 'Supplier Bill')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Supplier Bill
    @else
        Add Supplier Bill
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('supplierbills') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "supplierbills/$supplierbill->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "supplierbills",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <input type="hidden" name="requisition_id" value="{{(!empty($supplierbill->id) ? $supplierbill->id : null)}}">
        <div class="row">
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label style="!IMPORTANT background-color:#116A7B" class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($supplierbill) ? $supplierbill->costCenter->name : null),['class' => 'form-control','id' => 'project_name','placeholder'=>"Enter Project Name" ,'autocomplete'=>"off","required"])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($supplierbill) ? $supplierbill->costCenter->project_id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($supplierbill) ? $supplierbill->cost_center_id : null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon pr-5" for="register_serial_no">Bill Register Serial No<span class="text-danger">*</span></label>
                    {{Form::text('register_serial_no', old('register_serial_no') ? old('register_serial_no') : (!empty($supplierbill->register_serial_no) ? $supplierbill->register_serial_no : null),['class' => 'form-control','id' => 'register_serial_no','autocomplete'=>"off","required"])}}
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon pr-5" for="bill_no">Bill No</label>
                    {{Form::text('bill_no', old('bill_no') ? old('bill_no') : (!empty($supplierbill->bill_no) ? $supplierbill->bill_no : null),['class' => 'form-control','id' => 'bill_no','autocomplete'=>"off","required", 'readonly'])}}
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($supplierbill->date) ? $supplierbill->date : null),['class' => 'form-control','id' => 'date','autocomplete'=>"off","required", 'readonly'])}}
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Supplier Name<span class="text-danger">*</span></label>
                    {{Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($supplierbill->supplier->name) ? $supplierbill->supplier->name : null),['class' => 'form-control','id' => 'supplier_name','autocomplete'=>"off","required"])}}
                    {{Form::hidden('supplier_id', old('supplier_id') ? old('supplier_id') : (!empty($supplierbill->supplier_id) ? $supplierbill->supplier_id : null),['class' => 'form-control','id' => 'supplier_id','autocomplete'=>"off","required", 'readonly'])}}
                </div>
            </div>

            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="purpose">Purpose<span class="text-danger">*</span></label>
                    {{Form::textarea('purpose', old('purpose') ? old('purpose') : (!empty($supplierbill->purpose) ? $supplierbill->purpose : null),['class' => 'form-control','id' => 'purpose', 'rows'=>2, 'autocomplete'=>"off","required"])}}
                </div>
            </div>
        </div><!-- end row -->

        <div id="marerial_receiving_report">
        </div>


    <div class="table-responsive">
        <table id="purchaseTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Select MRR<span class="text-danger">*</span></th>
                    <th>PO No</th>
                    <th>MPR No</th>
                    {{-- <th>Supplier's Name</th> --}}
                    <th>Remarks</th>
                    <th>Amount<span class="text-danger">*</span></th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
            </thead>
            <tbody>
                @if(old('mrr_no'))
                    @foreach(old('mrr_no') as $key => $supplierbillOldData)
                    <tr>
                        <td>
                            <input type="number" name="mrr_no[]" value="{{old('mrr_no')[$key]}}" class="form-control mrr_no text-center" id="mrr_no">
                            <input type="hidden"  name="mrr_id[]"  class="form-control" value="" id="mrr_id">
                        </td>
                        <td>
                            <input type="text" name="po_no[]" value="{{ old("po_no.{$key}") }}" class="form-control po_no text-center" id="po_no" readonly tabindex="-1">
                        </td>
                        <td>
                            <input type="number" name="mpr_no[]" value="{{ old("mpr_no.{$key}") }}" id="mpr_no" class="form-control form-control-sm text-center mpr_no" readonly tabindex="-1">
                        </td>
                        {{-- <td>
                            <input type="text" name="supplier_name[]" value="{{ old("supplier_name.{$key}") }}" id="supplier_name" class="form-control supplier_name text-center" readonly readonly tabindex="-1">
                            <input type="hidden" name="supplier_id[]" value="{{ old("supplier_id.{$key}") }}" id="supplier_id" class="form-control supplier_id text-center" readonly readonly tabindex="-1">
                        </td> --}}
                        <td>
                            <textarea type="text" rows="1" name="remarks[]" value="{{ old("remarks.{$key}") }}" class="form-control remarks text-center"></textarea>
                        </td>
                        <td>
                            <input type="number" name="amount[]" value="{{ old("amount.{$key}") }}" class="form-control amount text-center" min="0" step="0.01" placeholder="0">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                        @if(!empty($supplierbill))
                            @foreach($supplierbill->officebilldetails as $officebilldetail)
                            <tr>
                                <td>
                                    <input type="number" name="mrr_no[]" value="{{$officebilldetail->mrr_no}}" class="form-control mrr_no text-center" id="mrr_no" tabindex="-1">
                                    <input type="hidden"   class="form-control" value="{{$officebilldetail->mrr_id}}" id="mrr_id" tabindex="-1">
                                </td>
                                <td>
                                    <input type="text" name="po_no[]" value="{{$officebilldetail->po_no}}" class="form-control po_no text-center" id="po_no" readonly tabindex="-1">
                                </td>
                                <td>
                                    <input type="number" name="mpr_no[]" value="{{$officebilldetail->mpr_no}}" id="mpr_no" class="form-control form-control-sm text-center mpr_no" readonly tabindex="-1">
                                </td>
                                {{-- <td>
                                    <input type="text" name="supplier_name[]" value="{{$officebilldetail->supplier->name}}" id="supplier_name" class="form-control supplier_name text-center" readonly readonly>
                                    <input type="hidden" name="supplier_id[]" value="{{$officebilldetail->supplier_id}}" id="supplier_id" class="form-control supplier_id text-center" readonly readonly>
                                </td> --}}
                                <td>
                                    <textarea type="text" rows="1" name="remarks[]" value="{{$officebilldetail->remarks}}" class="form-control remarks text-center">{{$officebilldetail->remarks}}</textarea>
                                </td>
                                <td>
                                    <input type="number" name="amount[]" value="{{$officebilldetail->amount}}" class="form-control amount text-center" min="0" step="0.01" placeholder="0">
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>

                            @endforeach
                        @endif
                    @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"> Sub Total </td>
                    <td>{{ Form::number('sub_total', old('sub_total', $supplierbill->sub_total ?? null), ['class' => 'form-control form-control-sm sub_total text-center', 'id' => 'sub_total', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"> Carrying Cost </td>
                    <td>{{ Form::number('carrying_charge', old('carrying_charge', $supplierbill->carrying_charge ?? null), ['class' => 'form-control form-control-sm carrying_charge text-center', 'id' => 'carrying_charge', 'placeholder' => '0.00 ']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"> Labour Charge </td>
                    <td>{{ Form::number('labour_charge', old('labour_charge', $supplierbill->labour_charge ?? null), ['class' => 'form-control form-control-sm labour_charge text-center', 'id' => 'labour_charge', 'placeholder' => '0.00 ']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"> Discount </td>
                    <td>{{ Form::number('discount', old('discount', $supplierbill->discount ?? null), ['class' => 'form-control form-control-sm discount text-center', 'id' => 'discount', 'placeholder' => '0.00 ']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right"> Total Amount </td>
                    <td>
                        {{ Form::number('final_total', old('final_total', $supplierbill->final_total ?? null), ['class' => 'form-control  form-control-sm final_total text-center', 'id' => 'final_total', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>


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


        // Function for adding new material row
        function addItemDtl() {
         /*   var Row = `
                <tr>
                    <td>
                        <input type="number" name="mrr_no[]"  class="form-control mrr_no" id="mrr_no">
                        <input type="hidden"   class="form-control text-center mrr_id" id="mrr_id">
                    </td>
                    <td><input type="text" name="po_no[]" class="form-control po_no text-center" id="po_no" readonly tabindex="-1"></td>
                    <td><input type="number" name="mpr_no[]" class="form-control form-control-sm mpr_no text-center" id="mpr_no" readonly tabindex="-1"></td>
                    <td>
                        <input type="text" name="supplier_name[]" class="form-control supplier_name text-center" id="supplier_name" readonly autocomplete="off" tabindex="-1">
                        <input type="hidden" name="supplier_id[]" id="supplier_id" class="form-control supplier_id text-center" readonly tabindex="-1">
                    </td>
                    <td><textarea type="text" rows="1" name="remarks[]" class="form-control remarks text-center" autocomplete="off" required></textarea></td>
                    <td><input type="number" name="amount[]" class="form-control amount text-center" min="0" step="0.01" placeholder = "0" autocomplete="off" readonly></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            */
              var Row = `
                <tr>
                    <td>
                        <input type="number" name="mrr_no[]"  class="form-control mrr_no" id="mrr_no">
                        <input type="hidden" class="form-control text-center mrr_id" id="mrr_id">
                    </td>
                    <td><input type="text" name="po_no[]" class="form-control po_no text-center" id="po_no" readonly tabindex="-1"></td>
                    <td><input type="number" name="mpr_no[]" class="form-control form-control-sm mpr_no text-center" id="mpr_no" readonly tabindex="-1"></td>

                    <td><textarea type="text" rows="1" name="remarks[]" class="form-control remarks text-center" autocomplete="off" required></textarea></td>
                    <td><input type="number" name="amount[]" class="form-control amount text-center" min="0" step="0.01" placeholder = "0" autocomplete="off" readonly></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;

            var tableItem = $('#purchaseTable').append(Row);
            totalOperation();
        }

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
            totalOperation();
        }

        // Function for calculating total price
        function totalOperation() {
            var total = 0;
            if ($(".amount").length > 0) {
                $(".amount").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#sub_total").val(total.toFixed(2));
        }

        // Function for calculating final total amount
        function calculateFinalTotal() {
            let sub_total = $("#sub_total").val() > 0 ? parseFloat($("#sub_total").val()) : 0;
            let carrying_charge = $("#carrying_charge").val() > 0 ? parseFloat($("#carrying_charge").val()) : 0;
            let labour_charge = $("#labour_charge").val() > 0 ? parseFloat($("#labour_charge").val()) : 0;
            let discount = $("#discount").val() > 0 ? parseFloat($("#discount").val()) : 0;
            $("#final_total").val((sub_total + carrying_charge + labour_charge) - discount);
        }


        // function for getting materials and quantity by mpr
        function getMrrByProject() {
                let cost_center_id = $("#cost_center_id").val();
                let supplier_id = $("#supplier_id").val();
                let url = '{{ url('scj/getMrrByProjectAndSupplier') }}/' + cost_center_id + '/' + supplier_id;

                $.getJSON(url, function(items) {
                    $.each(items, function(key, data) {
                        let info =
                            '<span class="label label-success tableBadge marerial_receiving_report" id="">' + data.label + '</span>';
                            $('#marerial_receiving_report').append(info);
                    })
                });
            }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            @if ($formType == 'create' && !old('po_id'))
                addItemDtl();
            @endif

            @if ($formType == 'edit')
                getMrrByProject();
            @endif

            $(document).on('keyup', ".mrr_no", function(){
                let cost_center_id = $("#cost_center_id").val();
                let supplier_id = $("#supplier_id").val();

                if(cost_center_id){
                    $(this).autocomplete({
                        source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.loadMrrBasedOnSupplier') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                cost_center_id : cost_center_id,
                                supplier_id:supplier_id
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).closest('#mrr_id').val(ui.item.value);
                        $(this).closest('#mrr_no').val(ui.item.label);
                        LoadPoMprSupplier($(this));
                        return false;
                        }
                    });
                }else{
                    $(document).on('keyup', ".mrr_no", function() {
                        alert("Search Project Name first");
                        $("#purchaseTable").children("tr").remove();
                        addItemDtl();
                    });
                }
            });


            $("#register_serial_no").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "{{route('scj.DepartmentWiseBillSearch')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function (data) {
                                if (data.length > 0) {
                                        response( data );
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
                                $(this).val("");
                                return false;
                            }
                        $('#register_serial_no').val(ui.item.label);
                        $('#bill_no').val(ui.item.bill_no);
                        return false;
                    }
                })

             // Function for LoadPoMprSupplier By Mrr
             function LoadPoMprSupplier(row) {
                let mrr_no = row.val();
                const url = '{{ url('LoadPoMprSupplierByMrr') }}/' + mrr_no;

                fetch(url)
                .then((resp) => resp.json())
                .then(function(details) {
                    console.log(details.amount);
                    row.closest('tr').find(".po_no").val(details[0].po_no);
                    row.closest('tr').find(".mpr_no").val(details[0].purchaseorder_for_po.mpr.mpr_no);
                    // row.closest('tr').find(".supplier_name").val(details[0].purchaseorder_for_po.supplier.name);
                    // row.closest('tr').find(".supplier_id").val(details[0].purchaseorder_for_po.supplier.id);
                    row.closest('tr').find(".amount").val(details.amount.toFixed(2));
                    totalOperation();
                    calculateFinalTotal();
                })
            }



            $('#date').datepicker({
                format: "dd-mm-yyyy", autoclose: true, todayHighlight: true, showOtherMonths:
                $("#project_name").autocomplete({
                    source: function (request, response) {
                        $.ajax({
                            url: "{{route('scj.projectAutoSuggestWithoutBOQ')}}",
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
                        $('#project_name').val(ui.item.label);
                        $('#project_id').val(ui.item.project_id);
                        $('#cost_center_id').val(ui.item.value);
                        // getMrrByProject();
                        return false;
                    }
                })

            });

            $(document).on('keyup change', '.amount', function() {
                totalOperation();
                calculateFinalTotal();
            });

            $(document).on('change keyup', '#carrying_charge', function() {
                calculateFinalTotal();
            });

            $(document).on('change keyup', '#labour_charge', function() {
                calculateFinalTotal();
            });

            $(document).on('change keyup', '#discount', function() {
                calculateFinalTotal();
            });
            totalOperation();
        });

        function LoadPoMprSupplier(row) {
            let mrr_no = $("#mrr_no").val();
            const url = '{{ url('LoadPoMprSupplierByMrr') }}/' + mrr_no;

            fetch(url)
                .then((resp) => resp.json())
                .then(function(details) {
                    row.closest('tr').find("#po_no").val(details.po_no);
                    row.closest('tr').find("#mpr_no").val(details.purchaseorder_for_po.mpr.mpr_no);
                   /* row.closest('tr').find("#supplier_name").val(details.purchaseorder_for_po.supplier.name);
                    row.closest('tr').find("#supplier_id").val(details.purchaseorder_for_po.supplier.id); */
                })
        }
        // $("body").on("contextmenu",function(e){
        //        return false;
        //   });
        $(document).bind('keydown', function(e) {
            if(e.ctrlKey && (e.which == 83)) {
                e.preventDefault();
                return false;
            }
            });


            $(document).on('keyup', "#supplier_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('supplierAutoSuggest') }}",
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
                        $('#supplier_name').val(ui.item.label);
                        $('#supplier_id').val(ui.item.value);
                        getMrrByProject();
                        return false;
                    }
                });
            });
    </script>
    <style>
    .custom-form .input-group-addon {
            min-width: 110px !important;
            max-width: 110px !important;
            background-color: #116A7B !important;
            padding-left: 4px !important;
            padding-right: 123px !important;
        }
    </style>

@endsection
