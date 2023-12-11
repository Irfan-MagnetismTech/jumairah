@extends('layouts.backend-layout')
@section('title', 'MPR')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Material Purchase Requisition(MPR)
    @else
        Add Material Purchase Requisition(MPR)
    @endif
    <style>
        .custom-form .input-group-addon {
            min-width: 163px !important;
        }
    </style>
@endsection

@section('breadcrumb-button')
    <a href="{{ url('requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if ($formType == 'edit')
        {!! Form::open(['url' => "requisitions/$requisition->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'requisitions', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif
    <input type="hidden" name="requisition_id" value="{{ !empty($requisition->id) ? $requisition->id : null }}">
    <div class="row">
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reason">MPR No.<span class="text-danger">*</span></label>
                @if (empty($requisition))
                    {{ Form::number('mpr_no', old('mpr_no') ? old('mpr_no') : (!empty($requisition) ? $requisition->mpr_no : null), ['class' => 'form-control', 'id' => 'mpr_no', 'placeholder' => 'MPR No.', 'required', 'autocomplete' => 'off']) }}
                    {{ Form::hidden('mpr_id', old('mpr_id') ? old('mpr_id') : (!empty($requisition) ? $requisition->mpr_no : null), ['class' => 'form-control', 'id' => 'mpr_id', 'autocomplete' => 'off', 'required']) }}
                @else
                    {{ Form::number('mpr_no', old('mpr_no') ? old('mpr_no') : (!empty($requisition) ? $requisition->mpr_no : null), ['class' => 'form-control', 'id' => 'mpr_no', 'placeholder' => 'MPR No.', 'required', 'autocomplete' => 'off', 'readonly']) }}
                    {{ Form::hidden('mpr_id', old('mpr_id') ? old('mpr_id') : (!empty($requisition) ? $requisition->mpr_no : null), ['class' => 'form-control', 'id' => 'mpr_id', 'autocomplete' => 'off', 'required']) }}
                @endif

            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($requisition) ? $requisition->costCenter->name : null), ['class' => 'form-control', 'id' => 'project_name', 'autocomplete' => 'off', 'required', 'placeholder' => 'Project Name']) }}
                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($requisition) ? $requisition->costCenter->project_id : null), ['class' => 'form-control', 'id' => 'project_id', 'autocomplete' => 'off']) }}
                {{ Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($requisition) ? $requisition->cost_center_id : null), ['class' => 'form-control', 'id' => 'cost_center_id', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                {{ Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($requisition) ? $requisition->applied_date : null), ['class' => 'form-control', 'id' => 'applied_date', 'autocomplete' => 'off', 'required', 'placeholder' => 'Applied Date', 'readonly']) }}
            </div>
        </div>
        {{-- @unlessrole('super-admin') --}}
            {{-- <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Approval Type<span class="text-danger">*</span></label>
                    {{ Form::select('approval_layer_id', $ApprovalLayerName, old('approval_layer_id') ? old('approval_layer_id') : (!empty($requisition) ? $requisition->approval_layer_id : 7), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'placeholder' => 'Select One']) }}
                    {{ Form::hidden('approval_layer_id', old('approval_layer_id') ? old('approval_layer_id') : (!empty($requisition) ? $requisition->approval_layer_id : 7), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'placeholder' => 'Select One']) }}
                </div>
            </div> --}}
            {{ Form::hidden('approval_layer_id', old('approval_layer_id') ? old('approval_layer_id') : (!empty($requisition) ? $requisition->approval_layer_id : 7), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'placeholder' => 'Select One']) }}

        {{-- @endunlessrole --}}
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="note">Note (Purpose,Brand, <br>Origin, Other
                    specifications)</label>
                {{ Form::textarea('note', old('note') ? old('note') : (!empty($requisition) ? $requisition->note : null), ['class' => 'form-control', 'id' => 'note', 'rows' => 2, 'autocomplete' => 'off', 'placeholder' => 'Note']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks(site)</label>
                {{ Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($requisition) ? $requisition->remarks : null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => 2, 'autocomplete' => 'off', 'placeholder' => 'Remarks(site)']) }}
            </div>
        </div>
    </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th width="200px">Floor Name</th>
                    <th>Material Name <span class="text-danger">*</span></th>
                    <th>Unit</th>
                    <th>Total Estimated<br>Requirement</th>
                    <th>Requisition <br> quantity</th>
                    <th>Net Comulative<br>Received</th>
                    <th>Present Stock</th>
                    <th>Required Presently<span class="text-danger">*</span></th>
                    <th width="120px">Required Delivery<br> Date</th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>

                @if (old('material_id'))
                    @foreach (old('material_id') as $key => $materialOldData)
                        <tr>
                            <td>
                                {{-- <input type="text" name="floor_name[]"   value="{{old('floor_name')[$key]}}" id="floor_name" class="form-control text-center form-control-sm floor_name"> --}}
                                {{-- <input type="hidden" name="floor_id[]"   value="{{old('floor_id')[$key]}}" id="floor_id" class="form-control text-center form-control-sm floor_id"> --}}
                                <select class="form-control form-control-sm floor_name" name="floor_id[]" id="floor_name"
                                    autocomplete="off">
                                    <option value=""></option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="material_name[]" value="{{ old('material_name')[$key] }}"
                                    class="form-control text-center form-control-sm material_name">
                                <input type="hidden" name="material_id[]" value="{{ old('material_id')[$key] }}"
                                    class="form-control form-control-sm text-center material_id" required>
                            </td>
                            <td><input type="text" name="unit[]" value="{{ old('unit')[$key] }}"
                                    class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                            <td><input type="number" name="boq_quantity[]" value="{{ old('boq_quantity')[$key] }}"
                                    class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly>
                            </td>
                            <td><input type="number" name="requisition_quantity[]"
                                    value="{{ old('requisition_quantity')[$key] }}"
                                    class="form-control text-center form-control-sm requisition_quantity" tabindex="-1"
                                    readonly></td>
                            <td><input type="number" name="taken_quantity[]" value="{{ old('taken_quantity')[$key] }}"
                                    class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly>
                            </td>
                            <td><input type="number" name="present_stock[]" value="{{ old('present_stock')[$key] }}"
                                    class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly>
                            </td>
                            <td><input type="number" name="quantity[]" value="{{ old('quantity')[$key] }}"
                                    class="form-control form-control-sm text-center quantity" min="0" step="0.001"
                                    placeholder="0.00" required autocomplete="off"></td>
                            <td><input type="date" name="required_date[]" value="{{ old('required_date')[$key] }}"
                                    class="form-control form-control-sm required_date" autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if (!empty($requisition))
                        @foreach ($requisition->requisitiondetails as $requisitiondetail)
                            @php
                                $boqMaterial = App\Procurement\NestedMaterial::whereHas('boqSupremeBudgets')
                                    ->whereAncestorOrSelf($requisitiondetail->material_id)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                
                                if (!empty($requisitiondetail->floor_id)) {
                                    $floorNo = $requisitiondetail->boqFloors->where('project_id', $requisitiondetail->requisition->costCenter->project_id)->first();
                                    $boq_quantity = App\Procurement\BoqSupremeBudget::where('project_id', $requisitiondetail->requisition->costCenter->project_id)
                                        ->where('floor_id', $floorNo->boq_floor_project_id)
                                        ->where('material_id', $boqMaterial->id)
                                        ->first();
                                
                                    $requisition_quantity = App\Procurement\Requisitiondetails::where('floor_id', $requisitiondetail->floor_id)
                                        ->where('material_id', $requisitiondetail->material_id)
                                        ->get()
                                        ->sum('quantity');
                                } else {
                                    $boq_quantity = App\Procurement\BoqSupremeBudget::where('project_id', $requisitiondetail->requisition->costCenter->project_id)
                                        ->where('material_id', $boqMaterial->id)
                                        ->first();
                                
                                    $requisition_quantity = App\Procurement\Requisitiondetails::whereNull('floor_id')
                                        ->where('material_id', $requisitiondetail->material_id)
                                        ->get()
                                        ->sum('quantity');
                                }
                                
                                $present_stock_in_stock_history = App\Procurement\StockHistory::where('cost_center_id', $requisitiondetail->requisition->cost_center_id)
                                    ->where('material_id', $requisitiondetail->material_id)
                                    ->latest()
                                    ->get();
                                
                                $material_receive_project_id = App\Procurement\MaterialReceive::where('cost_center_id', $requisitiondetail->requisition->cost_center_id)
                                    ->groupBy('cost_center_id')
                                    ->first();
                                
                                if (!empty($material_receive_project_id)) {
                                    $material_receive_details_quantity_sum = App\Procurement\Materialreceiveddetail::with('materialreceive')
                                        ->whereHas('materialreceive', function ($query) use ($material_receive_project_id) {
                                            return $query->where('cost_center_id', $material_receive_project_id->cost_center_id);
                                        })
                                        ->where('material_id', $requisitiondetail->material_id)
                                        ->get()
                                        ->sum('quantity');
                                }
                                $budgeted_quantity = $boq_quantity->quantity ?? 0;
                                $taken_quantity = $material_receive_details_quantity_sum ?? 0;
                                $present_stock = count($present_stock_in_stock_history) ? $present_stock_in_stock_history[0]->present_stock : 0;
                                $max_quantity = $budgeted_quantity - $requisition_quantity - $requisitiondetail->quantity;
                            @endphp
                            <tr>
                                <td>
                                    <input type="text" name="floor_name[]"
                                        value="{{ !empty($requisitiondetail->boqFloor->name) ? $requisitiondetail->boqFloor->name : '' }}"
                                        id="floor_name" class="form-control text-center form-control-sm">
                                    <input type="hidden" name="floor_id[]"
                                        value="{{ !empty($requisitiondetail->floor_id) ? $requisitiondetail->floor_id : '' }}"
                                        id="floor_id" class="form-control form-control-sm text-center floor_name">
                                </td>
                                <td>
                                    <input type="text" name="material_name[]"
                                        value="{{ $requisitiondetail->nestedMaterial->name }}"
                                        class="form-control text-center form-control-sm material_name">
                                    <input type="hidden" name="material_id[]"
                                        value="{{ $requisitiondetail->nestedMaterial->id }}"
                                        class="form-control form-control-sm text-center material_id" required>
                                </td>
                                <td><input type="text" name="unit[]"
                                        value="{{ $requisitiondetail->nestedMaterial->unit->name }}"
                                        class="form-control text-center form-control-sm text-center unit" readonly
                                        tabindex="-1"></td>
                                <td><input type="number" name="boq_quantity[]" value="{{ $budgeted_quantity }}"
                                        class="form-control text-center form-control-sm boq_quantity" tabindex="-1"
                                        readonly></td>
                                <td><input type="number" name="requisition_quantity[]"
                                        value="{{ $requisition_quantity ?? 0 }}"
                                        class="form-control text-center form-control-sm requisition_quantity"
                                        tabindex="-1" readonly></td>
                                <td><input type="number" name="taken_quantity[]" value="{{ $taken_quantity }}"
                                        class="form-control text-center form-control-sm taken_quantity" tabindex="-1"
                                        readonly></td>
                                <td><input type="number" name="present_stock[]" value="{{ $present_stock }}"
                                        class="form-control text-center form-control-sm prestent_stock" tabindex="-1"
                                        readonly></td>
                                <td><input type="number" name="quantity[]" value="{{ $requisitiondetail->quantity }}"
                                        class="form-control form-control-sm text-center quantity" min="0"
                                        max="{{ number_format($max_quantity, 3) }}" step="0.001" placeholder="0.000"
                                        required autocomplete="off"></td>
                                <td><input type="text" name="required_date[]"
                                        value="{{ $requisitiondetail->required_date }}" readonly
                                        class="form-control form-control-sm required_date" autocomplete="off"></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
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
        function addRow() {
            let row = `
                <tr>
                    <td>
                        <select class ="form-control form-control-sm floor_name"  name="floor_id[]" id="floor_name" autocomplete="off">
                            <option value=""></option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="material_list[]" class="material_list">
                        <input type="hidden" name="material_id[]" class="material_id" id="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="number" name="boq_quantity[]" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                    <td><input type="number" name="requisition_quantity[]" class="form-control text-center form-control-sm requisition_quantity" tabindex="-1" readonly></td>
                    <td><input type="number" name="taken_quantity[]" class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>

                    <td><input type="number" name="present_stock[]" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control form-control-sm text-center quantity"  step="0.001" placeholder="0.00" required autocomplete="off"></td>
                    <td><input type="text" name="required_date[]" class="form-control form-control-sm required_date" autocomplete="off" placeholder="Required Date" readonly></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            // check double entry protection of material for a floor
            function checkFloorWiseMaterialDoubleEntry(currentRow) {
                let costCenterId = $("#cost_center_id").val();

                let currentFloorId = $(currentRow).closest('tr').find(".floor_name").val();
                let currentMaterialId = $(currentRow).closest('tr').find(".material_id").val();
                let currentFloorMaterial = `${currentFloorId}-${currentMaterialId}`;
                let materialNames = $(".floor_name").not($(currentRow).closest('tr').find(".floor_name"));

                materialNames.each(function() {
                    let floorId = $(this).closest('tr').find(".floor_name").val();
                    let materialId = $(this).closest('tr').find(".material_id").val();
                    let floorMaterial = `${floorId}-${materialId}`;
                    if (floorId) {
                        if (floorMaterial == currentFloorMaterial) {
                            alert("Duplicate Found");
                            $(this).closest('tr').remove();
                        }
                    } else {
                        if (materialId == currentMaterialId) {
                            alert("Duplicate Found");
                            $(this).closest('tr').remove();
                        }
                    }
                });
            }

            @if ($formType == 'create' && !old('material_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function() {
                addRow();
                loadProjectWiseFloor(this);

            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });

            $('#date,#applied_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            $(document).on('mouseenter', '.required_date', function() {
                $(this).datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true,
                });
            });

            // Function for autocompletion of projects

            $("#project_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.projectAutoSuggest') }}",
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
                    $('#cost_center_id').val(ui.item.value);
                    $('#project_id').val(ui.item.project_id);
                    $('#project_name').val(ui.item.label);
                    $("#itemTable").find("tbody").children("tr").remove();
                    addRow();
                    loadProjectWiseFloor();
                    return false;
                }
            })

            // Function for autocompletion of floor

            function loadProjectWiseFloor(item) {
                let project_id = $("#project_id").val();
                if (project_id) {
                    const url = '{{ url('scj/loadProjectWiseFloor') }}/' + project_id;
                    let dropdown;

                    $('.floor_name').each(function() {
                        dropdown = $(this).closest('tr').find('.floor_name');
                    });
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Floor</option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function(items) {
                        $.each(items, function(key, data) {
                            dropdown.append($('<option></option>').attr('value', data.value).text(
                                data.label));
                        })
                    });
                }
            };

            $(document).on('keyup', ".material_name", function() {
                let cost_center_id = $("#cost_center_id").val();
                let project_id = $("#project_id").val();
                let floor_name = $(this).closest('tr').find(".floor_name").val();

                if (project_id && floor_name) {
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: '{{ route('scj.floorswiseBOQbudgetedMaterials') }}',
                                type: 'get',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    project_id: project_id,
                                    floor_name: floor_name
                                },
                                success: function(data) {
                                    response(data);
                                }
                            });
                        },
                        select: function(event, ui) {
                            let vm = this;
                            $(this).val(ui.item.label);
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                            $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                            $(this).closest('tr').find('.boq_quantity').val(ui.item.quantity);
                            $(this).closest('tr').find('.material_list').val(ui.item
                                .material_list);
                            let material_id = ui.item.material_id;

                            $.ajax({
                                url: '{{ route('scj.getRequisionDetailsByProjectAndMaterial') }}',

                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    cost_center_id: cost_center_id,
                                    project_id: project_id,
                                    floor_name: floor_name,
                                    material_id: material_id

                                },
                                success: function(data) {
                                    let taken_quantity = data
                                        .material_receive_quantity_sum;
                                    let present_stock = data
                                        .present_stock_in_stock_history;
                                    let max_quantity = ui.item.quantity - data
                                        .requisition_quantity;
                                    $(vm).closest('tr').find(
                                        '.requisition_quantity').val(data
                                        .requisition_quantity);
                                    $(vm).closest('tr').find('.taken_quantity').val(
                                        taken_quantity);
                                    $(vm).closest('tr').find('.prestent_stock').val(
                                        present_stock);
                                    $(vm).closest('tr').find('.quantity').attr(
                                        'max', max_quantity.toFixed(3));


                                    find_max(vm);

                                }
                            });
                            checkFloorWiseMaterialDoubleEntry($(this));
                        }
                    });

                } else if (project_id) {
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: '{{ route('scj.ProjectWiseBOQbudgetedMaterials') }}',
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    project_id: project_id
                                },
                                success: function(data) {
                                    response(data);
                                }
                            });

                        },
                        select: function(event, ui) {
                            let vm = this;
                            $(this).val(ui.item.label);
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                            $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                            $(this).closest('tr').find('.boq_quantity').val(ui.item.quantity);
                            $(this).closest('tr').find('.material_list').val(ui.item
                                .material_list);
                            let material_id = ui.item.material_id;

                            $.ajax({
                                url: '{{ route('scj.getRequisionDetailsByProjectAndMaterial') }}',

                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    cost_center_id: cost_center_id,
                                    project_id: project_id,
                                    material_id: material_id

                                },
                                success: function(data) {
                                    let taken_quantity = data
                                        .material_receive_quantity_sum;
                                    let present_stock = data
                                        .present_stock_in_stock_history;
                                    let max_quantity = ui.item.quantity - data
                                        .requisition_quantity;
                                    $(vm).closest('tr').find(
                                        '.requisition_quantity').val(data
                                        .requisition_quantity);
                                    $(vm).closest('tr').find('.taken_quantity').val(
                                        taken_quantity);
                                    $(vm).closest('tr').find('.prestent_stock').val(
                                        present_stock);
                                    $(vm).closest('tr').find('.quantity').attr(
                                        'max', max_quantity.toFixed(3));
                                    find_max(vm);
                                }
                            });
                            checkFloorWiseMaterialDoubleEntry($(this));
                        }
                    });
                } else {
                    $(document).on('keyup', ".material_name", function() {
                        let project_id = $("#project_id").val();
                        if ((project_id = true)) {
                            alert("Search project name first");
                            $("#itemTable").find("tbody").children("tr").remove();
                            addRow();
                        }
                    });
                };
            });
        });

        function loadProjectWiseFloorforOld(item) {
            let project_id = $("#project_id").val();
            if (project_id) {
                const url = '{{ url('scj/loadProjectWiseFloor') }}/' + project_id;
                let dropdown;

                dropdown = $('.floor_name');
                dropdown.empty();
                dropdown.append('<option selected disabled value="0">Select Floor</option>');
                dropdown.prop('selectedIndex', 0);

                $.getJSON(url, function(items) {
                    $.each(items, function(key, data) {
                        dropdown.append($('<option></option>').attr('value', data.value).text(data.label));
                    })
                });
            }
        };

        function find_max(vm) {

            let materials_old = $(".material_id");
            let materials = $(".material_list").not($(vm).closest('tr').find(".material_list"));
            var mat_code = [];
            var maxxx = 0;
            materials_old.each(function() {
                let floor_name = $(vm).closest('tr').find(".floor_name").val();
                let material_id = $(vm).closest('tr').find('.material_id').val();
                let mat_id = $(this).closest('tr').find('.material_list').val().split(',').map(iNum => parseInt(
                    iNum, 10));
                let floor_id = $(this).closest('tr').find('.floor_name').val();
                let format_mat = floor_id + '_' + mat_id.join('_');
                if (!mat_code.includes(format_mat)) {
                    mat_code.push(format_mat);
                    console.log('format_mat', mat_id.includes(Number(material_id)), (floor_name == floor_id));
                    if (mat_id.includes(Number(material_id)) && (floor_name == floor_id)) {
                        maxxx = Number($(this).closest('tr').find('.boq_quantity').val()) - Number($(this).closest(
                            'tr').find('.requisition_quantity').val());
                    }
                } else {
                    if (mat_id.includes(Number(material_id)) && (floor_name == floor_id)) {
                        maxxx -= Number($(this).closest('tr').find('.requisition_quantity').val());
                    }
                }
            })

            materials.each(function() {
                let floor_name = $(vm).closest('tr').find(".floor_name").val();
                let material_id = $(vm).closest('tr').find('.material_id').val();
                let mat_id = $(this).val().split(',').map(iNum => parseInt(iNum, 10));
                let floor_id = $(this).closest('tr').find('.floor_name').val();
                if (mat_id.includes(Number(material_id)) && (floor_name == floor_id)) {
                    maxxx -= Number($(this).closest('tr').find('.quantity').val());
                }
            })
            $(vm).closest('tr').find('.quantity').attr('max', maxxx);
        }

        $(document).ready(function() {
            @if (old('material_id'))
                loadProjectWiseFloorforOld();
            @endif
        })

        $(document).on('change keyup', ".quantity", function() {
            let vm = this;
            find_max(vm);
        });
    </script>
@endsection
