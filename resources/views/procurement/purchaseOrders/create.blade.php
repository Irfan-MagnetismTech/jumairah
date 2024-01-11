@extends('layouts.backend-layout')
@section('title', 'Purchase Orders')

@section('breadcrumb-title')
    {{ empty($purchaseOrder) ? 'New Purchase Order' : 'Edit Purchase Order' }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('purchaseOrders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    {!! Form::open(['url' => empty($purchaseOrder) ? route('purchaseOrders.store') : route('purchaseOrders.update', $purchaseOrder->id), 'method' => empty($purchaseOrder) ? 'POST' : 'PUT', 'class' => 'custom-form']) !!}

    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="po_no">Purchase Order No: <span class="text-danger">*</span></label>
                @if(empty($purchaseOrder))
                {{ Form::text('po_no', old('po_no', $purchaseOrder->po_no ?? null), ['class' => 'form-control', 'id' => 'po_no', 'autocomplete' => 'off', 'required']) }}
                @else
                {{ Form::text('po_no', old('po_no', $purchaseOrder->po_no ?? null), ['class' => 'form-control', 'id' => 'po_no','autocomplete' => 'off', 'required', 'readonly']) }}
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Purchase Date<span class="text-danger">*</span></label>
                @if(empty($purchaseOrder))
                {{ Form::text('date', old('date', $purchaseOrder->date ?? null), ['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off', 'required']) }}
                @else
                {{ Form::text('date', old('date', $purchaseOrder->date ?? null), ['class' => 'form-control', 'id' => 'date','autocomplete' => 'off', 'required', 'readonly']) }}
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="mpr_no"> MPR No. <span class="text-danger">*</span></label>
                {{ Form::text('mpr_label', old('mpr_label', $purchaseOrder->mpr->mpr_no ?? null), ['class' => 'form-control mpr_label', 'id' => 'mpr_label', 'required']) }}
                {{ Form::hidden('mpr_no', old('mpr_no', $purchaseOrder->mpr->id ?? null), ['class' => 'form-control mpr_no', 'id' => 'mpr_no', 'autocomplete' => 'off', 'required']) }}

            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="mpr_no"> MPR Date <span class="text-danger">*</span></label>

                {{ Form::text('mpr_date', old('mpr_date', $purchaseOrder->mpr->applied_date ?? null), ['class' => 'form-control mpr_date', 'id' => 'mpr_date','readonly']) }}
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cs_no"> CS Ref No. <span class="text-danger">*</span></label>
                {{ Form::text('cs_no', old('cs_no', $purchaseOrder->cs->reference_no ?? null), ['class' => 'form-control cs_no', 'id' => 'cs_no', 'required']) }}
                {{ Form::hidden('cs_id', old('cs_id', $purchaseOrder->cs->id ?? null), ['class' => 'form-control cs_id', 'id' => 'cs_id', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_id">Supplier Name<span class="text-danger">*</span></label>
                {{ Form::select('supplier_id', $suppliers, old('supplier_id') ? old('supplier_id') :(!empty($purchaseOrder->supplier_id) ? $purchaseOrder->supplier_id : null), ['class' => 'form-control', 'id' => 'supplier_id', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required']) }}

            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project Name <span class="text-danger">*</span></label>
                {{ Form::text('project_id', old('project_id', $purchaseOrder->mpr->costCenter->project->name ?? null), ['class' => 'form-control', 'id' => 'project_id', 'readonly', 'tabindex' => -1, 'autocomplete' => 'off', 'required']) }}
                {{ Form::hidden('po_project_id', old('po_project_id', $purchaseOrder->mpr->costCenter->project->id ?? null), ['class' => 'form-control', 'id' => 'po_project_id']) }}
                {{ Form::hidden('cost_center_id', old('cost_center_id', $purchaseOrder->mpr->cost_center_id ?? null), ['class' => 'form-control', 'id' => 'cost_center_id']) }}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_vat"> Source VAT <span class="text-danger">*</span></label>
                {{ Form::text('source_vat', old('source_vat', $purchaseOrder->source_vat ?? null), ['class' => 'form-control', 'id' => 'source_vat', 'autocomplete' => 'off','required','readonly']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_tax"> Source Tax <span class="text-danger">*</span></label>
                {{ Form::text('source_tax', old('source_tax', $purchaseOrder->source_tax ?? null), ['class' => 'form-control', 'id' => 'source_tax', 'autocomplete' => 'off', 'required','readonly']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="carrying"> Carrying <span class="text-danger">*</span></label>
                {{ Form::text('carrying',old('carrying', $purchaseOrder->carrying ?? null), ['class' => 'form-control', 'id' => 'carrying', 'autocomplete' => 'off', 'required','readonly']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="receiver_name"> Receiver Name <span class="text-danger">*</span></label>
                {{ Form::text('receiver_name', old('receiver_name', $purchaseOrder->receiver_name ?? null), ['class' => 'form-control', 'id' => 'receiver_name', 'autocomplete' => 'off','required']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="receiver_contact"> Receiver Contact <span class="text-danger">*</span></label>
                {{ Form::text('receiver_contact', old('receiver_contact', $purchaseOrder->receiver_contact ?? null), ['class' => 'form-control', 'id' => 'receiver_contact', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks"> Remarks</label>
                {{ Form::textarea('remarks', old('remarks', $purchaseOrder->remarks ?? null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => 2, 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>

    <div id="material_and_quantity">
    </div>


    <div class="table-responsive">
        <table id="purchaseTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th >Material Name<span class="text-danger">*</span></th>
                    <th >Unit</th>
                    <th >Brand</th>
                    <th >Required Date<span class="text-danger">*</span></th>
                    <th >Quantity<span class="text-danger">*</span></th>
                    <th >Rate<span class="text-danger">*</span></th>
                    <th >Total Price<span class="text-danger">*</span></th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
            </thead>
            <tbody>
                @forelse (old('material_id', $purchaseOrder->purchaseOrderDetails ?? []) as $key => $value)
                <?php
                $mpr_no = $purchaseOrder->mpr->id;

                $purchaseOrderDetails = App\Procurement\PurchaseOrderDetail::where('material_id', $value->nestedMaterials->id)
                ->whereHas('purchaseOrder', function ($query) use ($mpr_no) {
                $query->where('mpr_no', $mpr_no);
                })
                ->sum('quantity');

                $requisition_details = App\Procurement\Requisitiondetails::where('requisition_id', $mpr_no)
                ->where('material_id', $value->nestedMaterials->id)
                ->sum('quantity');


                $maxValue = ($requisition_details - $purchaseOrderDetails) + ($value->quantity);
                ?>
                    <tr>
                        <td>
                            <select class="form-control form-control-sm material_name" name="material_id[]" required>
                                <option selected disabled>Select Material </option>
                                @foreach ($materials as $material_id => $material)
                                    <option value="{{ $material_id }}" @if (old("material_id.{$key}", $value->nestedMaterials->id ?? null) == $material_id) selected @endif>
                                        {{ $material }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" name="unit[]" value="{{ old("unit.{$key}", $value->nestedMaterials->unit->name ?? null) }}" class="form-control form-control-sm text-center unit" readonly tabindex="-1">
                        </td>
                        <td>
                            <input type="text" name="brand[]" value="{{ old("brand.{$key}", $value->brand ?? null) }}" class="form-control brand text-center">
                        </td>
                        <td>
                            <input type="text" name="required_date[]" value="{{ old("required_date.{$key}", $value->required_date ?? null) }}" class="form-control required_date text-center" autocomplete="off">
                        </td>
                        <td>
                            <input type="number" name="quantity[]" value="{{ old("number.{$key}", $value->quantity ?? null) }}" class="form-control quantity text-center" min="0" step="0.05" placeholder="0" max="{{ $maxValue }}">
                        </td>
                        <td>
                            <input type="number" name="unit_price[]" value="{{ old("unite_price.{$key}", $value->unit_price ?? null) }}" class="form-control unit_price text-center" min="0"  placeholder="0" readonly>
                        </td>
                        <td>
                            <input type="number" name="total_price[]" value="{{ old("total_price.{$key}", $value->total_price ?? null) }}" class="form-control total_price text-center" readonly tabindex="-1">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                <i class="fa fa-minus"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right"> Sub Total </td>
                    <td>{{ Form::number('sub_total', old('sub_total', $purchaseOrder->sub_total ?? null), ['class' => 'form-control form-control-sm sub_total text-center', 'id' => 'sub_total', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right"> Carrying Cost </td>
                    <td>{{ Form::number('carrying_charge', old('carrying_charge', $purchaseOrder->carrying_charge ?? null), ['class' => 'form-control form-control-sm carrying_charge text-center', 'id' => 'carrying_charge', 'placeholder' => '0.00 ']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right"> Labour Charge </td>
                    <td>{{ Form::number('labour_charge', old('labour_charge', $purchaseOrder->labour_charge ?? null), ['class' => 'form-control form-control-sm labour_charge text-center', 'id' => 'labour_charge', 'placeholder' => '0.00 ']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right"> Discount </td>
                    <td>{{ Form::number('discount', old('discount', $purchaseOrder->discount ?? null), ['class' => 'form-control form-control-sm discount text-center', 'id' => 'discount', 'placeholder' => '0.00 ']) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-right"> Total Amount </td>
                    <td>
                        {{ Form::number('final_total', old('final_total', $purchaseOrder->final_total ?? null), ['class' => 'form-control  form-control-sm final_total text-center', 'id' => 'final_total', 'placeholder' => '0.00 ', 'readonly']) }}
                    </td>
                </tr>
            </tfoot>
        </table>
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
    <script>
        const material_row_data = @json(old('material_id', []));
        const CSRF_TOKEN = "{{ csrf_token() }}";

        // Function for adding new material row
        function addItemDtl() {
            var Row = `
                <tr>
                    <td>
                        <select class ="form-control form-control-sm material_name"  name="material_id[]" required>
                            <option value="">Select Material</option>
                        </select>
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control-sm unit text-center" readonly tabindex="-1"></td>
                    <td><input type="text" name="brand[]" class="form-control brand text-center"  autocomplete="off"></td>
                    <td><input type="text" name="required_date[]" class="form-control required_date text-center" autocomplete="off" required></td>
                    <td><input type="number" name="quantity[]" class="form-control quantity text-center" min="0" step="0.01" placeholder = "0" autocomplete="off" required></td>
                    <td><input type="number" name="unit_price[]" class="form-control unit_price text-center" min="0" step="0.01" placeholder = "0" autocomplete="off" readonly required></td>
                    <td><input type="number" name="total_price[]" class="form-control total_price text-center" readonly tabindex="-1"></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            var tableItem = $('#purchaseTable tbody').append(Row);
            getMaterial();
            calculateTotalPrice(this);
            totalOperation();
        }

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
            totalOperation();
            calculateFinalTotal();
        }
        // Function for calculating total price
        function calculateTotalPrice(thisVal) {
            let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.quantity').val()) : 0;
            let unit_price = $(thisVal).closest('tr').find('.unit_price').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.unit_price').val()) : 0;
            let total = (quantity * unit_price).toFixed(2);
            $(thisVal).closest('tr').find('.total_price').val(total);
            totalOperation();
        }

        // Function for calculating total price
        function totalOperation() {
            var total = 0;
            if ($(".total_price").length > 0) {
                $(".total_price").each(function(i, row) {
                    var total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#sub_total").val(total.toFixed(2));
            calculateFinalTotal();
        }

        // Function for calculating final total amount
        function calculateFinalTotal() {
            let sub_total = $("#sub_total").val() > 0 ? parseFloat($("#sub_total").val()) : 0;
            let carrying_charge = $("#carrying_charge").val() > 0 ? parseFloat($("#carrying_charge").val()) : 0;
            let labour_charge = $("#labour_charge").val() > 0 ? parseFloat($("#labour_charge").val()) : 0;
            let discount = $("#discount").val() > 0 ? parseFloat($("#discount").val()) : 0;
            $("#final_total").val((sub_total + carrying_charge + labour_charge) - discount);
        }

        // Function for getting material by mpr_no and cs_id
        function getMaterial() {
            let mpr_id = $("#mpr_no").val();
            let cs_id = $("#cs_id").val();

            if (mpr_id != '' && cs_id != '') {
                const url = '{{ url('scj/loadMprMaterial') }}/' + mpr_id + '/' + cs_id;
                let dropdown;

                $('.material_name').each(function() {
                    dropdown = $(this).closest('tr').find('.material_name');
                });
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Material</option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function(items) {
                        $.each(items, function(key, mpr_material) {

                            dropdown.append($('<option></option>')
                                .attr('value', mpr_material.material_id)
                                .text(mpr_material.nested_material.name))
                        })
                    });
            }
        }

        // Function for laoding details of a selected material
        function loadmaterial(data) {
            let supplier_id = $("#supplier_id").val();
            loadcsPrice(data);
            let material_id = $(data).val();
            let requisition_id = $("#mpr_no").val();
            const url = '{{ url('scj/loadrequisitionmaterial') }}/' + material_id + '/' + requisition_id;

            fetch(url)
                .then((resp) => resp.json())
                .then(function(material) {
                    let requisition_quantity = material.sum;
                    let purchase_order_quantity = material.po_quantity;
                    let max_quantity = requisition_quantity - purchase_order_quantity;

                    $(data).closest('tr').find(".unit").val(material.value);

                    $(data).closest('tr').find(".quantity").attr('max', max_quantity);
                    return false;
                }).then(function(){
                    calculateTotalPrice($(data));
                })
        }
        function loadcsPrice(data) {
            let supplier_id = $("#supplier_id").val();
            let cs_id = $("#cs_id").val();
            let material_id = $(data).val();
            const url = '{{ url('scj/GetCsPriceforMpr') }}/' + cs_id + '/' + material_id+ '/' + supplier_id;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(price) {
                    $(data).closest('tr').find(".unit_price").val(price.csPrice);
                    return false;
                })
        }

        // Function for getting CS supplier
        function getCsSupplier() {
            const cs_supplier = $("#cs_id").val();

            if (cs_supplier != '') {
                const url = '{{ url('loadCsSupplier') }}/' + cs_supplier;
                let dropdown = $('#supplier_id');
                let oldSelectedItem = "{{ old('supplier_id', $purchaseOrder->supplier_id ?? '') }}";

                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Supplier </option>');
                dropdown.prop('selectedIndex', 0);

                $.getJSON(url, function(items) {
                    $.each(items, function(key, cs_supplier) {
                        let select = (oldSelectedItem == cs_supplier.id) ? "selected" : null;
                        let options =
                            `<option value="${cs_supplier.supplier_id}" ${select}>${cs_supplier.supplier.name}</option>`;
                        dropdown.append(options);
                    })
                });
            }
        }

        function findSupplierInfo() {
            const cs_id = $("#cs_id").val();
            const supplier_id = $("#supplier_id").val();
            $.ajax({
                    url: "{{ route('scj.findSupplierDetailInfo') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        cs_id,
                        supplier_id
                    },
                    success: function(data) {
                        $("#source_vat").val(data.vat_tax);
                        $("#source_tax").val(data.tax);
                        $("#carrying").val(data.delivery_condition);
                    }
                });
        }

        // Function for laodging CS projects
        function loadCsProject() {
            let dropdown = $('#project_id');
            let oldSelectedItem = "{{ old('project_id') ? old('project_id') : null }}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Project </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{ url('loadCsProject') }}/' + $("#cs_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function(items) {
                $.each(items, function(key, cs_project) {
                    let select = (oldSelectedItem == cs_project.id) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', cs_project.id).text(
                        cs_project.project.name));
                })
            });
        }

        // Function for autocompletion of cs_no
        $("#cs_no").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('csAutoSuggest') }}",
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
                $('#cs_id').val(ui.item.value);
                loadCsProject();
                getCsSupplier();
                getMaterial();
                return false;
            }
        });

        // Function for autocompletion of mpr_no
        $("#mpr_label").autocomplete({
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
                $('#mpr_label').val(ui.item.label);
                $('#mpr_no').val(ui.item.value);
                $('#mpr_date').val(ui.item.date);
                $('#project_id').val(ui.item.project_id);
                $('#po_project_id').val(ui.item.po_project_id);
                $('#cost_center_id').val(ui.item.cost_center_id);
                $('#receiver_name').val(ui.item.receiver_name);
                $('#receiver_contact').val(ui.item.receiver_contact);
                getMaterialsAndQuantityByMpr();
                return false;
            }
        });



        // function for getting materials and quantity by mpr
        function getMaterialsAndQuantityByMpr() {
                let mpr_no = $("#mpr_no").val();
                let url = '{{ url('scj/getMaterialsAndQuantityByMpr') }}/' + mpr_no;

                $.getJSON(url, function(items) {
                    $.each(items, function(key, data) {
                        let info =
                            '<span class="label label-success tableBadge material_and_quantity" id="">' + data.material_name + ' --- ' + data.po_quantity + '</span>';
                            $('#material_and_quantity').append(info);
                    })
                });
            }

        $(function() {
            @if ($formType == 'create' && !old('material_id')) addItemDtl(); @endif

            $(document).on('keyup change', '.quantity,.unit_price', function() {
                calculateTotalPrice(this);
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

            $(document).on('click', '.material_name', function() {
                let supplier_id = $("#supplier_id").val();
                if(supplier_id == null || supplier_id == ''){
                alert("Please select supplier first");
                return false;
            }
            });
            $(document).on('change', '.material_name', function() {
                loadmaterial($(this));
            });
            $(document).on('change', '#supplier_id', function() {
                $('#purchaseTable tbody').find('tr').detach();
                findSupplierInfo();
                addItemDtl();
            });

            @if ($formType == 'edit')
            getMaterialsAndQuantityByMpr();

            @endif

            $(document).on('mouseenter', '.required_date', function() {
                $(this).datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });

            totalOperation();
            // Date picker formatter
            $('#date,.required_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        }) // Document.Ready
    </script>
@endsection
