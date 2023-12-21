@extends('layouts.backend-layout')
@section('title', 'Material Receive Report ')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Material Receiving Report(MRR)
    @else
        Add Material Receiving Report(MRR)
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('materialReceives') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')



    @if ($formType == 'edit')
        {!! Form::open(['url' => "materialReceives/$materialReceived->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'materialReceives', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">

                <div class="d-flex">
                    <input type="radio" id="withIou" class="mrr_type" name="mrr_type" value="withIou" style="margin-left: 30px;" {{ (!empty($materialReceived->iou_id) ? 'checked': "") }}>
                    <label  style="margin-left: 5px; margin-top: 7px" for="withIou">With Iou</label>
                </div>
               <div class="d-flex">
                    <input type="radio" id="withOutIou" class="mrr_type" value="withOutIou" name="mrr_type" style="margin-left: 30px;" {{  (empty($materialReceived->iou_id) && !empty($materialReceived) ? 'checked' : "") }}>
                    <label  style="margin-left: 5px; margin-top: 7px" for="withOutIou">Without Iou</label>
               </div>


            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                {{ Form::text('date',old('date') ? old('date') : (!empty($materialReceived->date) ? $materialReceived->date : null),['class' => 'form-control', 'id' => 'date', 'autocomplete' => 'off', 'readonly']) }}
            </div>
        </div>
    </div>
    <div class="withOutIou" style="{{ ((isset($materialReceived) && empty($materialReceived->iou_id)) ? '': "display:none") }}">


        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="mpr_no">MPR Tracking No.<span class="text-danger">*</span></label>
                    {{ Form::number('mpr_no',old('mpr_no')? old('mpr_no'): (!empty($materialReceived->purchaseorderForPo->mpr->mpr_no)? $materialReceived->purchaseorderForPo->mpr->mpr_no: null),['class' => 'form-control','id' => 'mpr_no','placeholder' => 'Enter MPR Tracking No.','autocomplete' => 'off']) }}
                    {{ Form::hidden('mpr_id',old('mpr_id')? old('mpr_id'): (!empty($materialReceived->purchaseorderForPo->mpr->id)? $materialReceived->purchaseorderForPo->mpr->id: null),['class' => 'form-control', 'id' => 'mpr_id', 'autocomplete' => 'off']) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="po_no">PO No.<span class="text-danger">*</span></label>
                    {{ Form::select('po_no', $purchase_orders, null, ['class' => 'form-control','id' => 'po_no','autocomplete' => 'off']) }}
                    {{ Form::hidden('po_id',old('po_id') ? old('po_id') : (!empty($materialReceived->id) ? $materialReceived->id : null),['class' => 'form-control', 'id' => 'po_id', 'autocomplete' => 'off']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="cs_no"> CS Ref No. <span class="text-danger">*</span></label>
                    {{ Form::text('cs_no', old('cs_no', $materialReceived->purchaseorderForPo->cs->reference_no ?? null), ['class' => 'form-control cs_no','id' => 'cs_no','readonly']) }}
                    {{ Form::hidden('cs_id', old('cs_id', $materialReceived->purchaseorderForPo->cs->id ?? null), ['class' => 'form-control cs_id','id' => 'cs_id','autocomplete' => 'off']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="po_dated">PO Date</label>
                    {{ Form::text('po_dated',old('po_dated')? old('po_dated'): (!empty($materialReceived?->purchaseorderForPo?->date)? $materialReceived?->purchaseorderForPo?->date: null),['class' => 'form-control', 'id' => 'po_dated', 'autocomplete' => 'off', 'readonly']) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name <span class="text-danger">*</span></label>
                    {{ Form::text('project_name', old('project_name', $materialReceived->costCenters->name ?? null), ['class' => 'form-control','id' => 'project_name','readonly','tabindex' => -1,'autocomplete' => 'off']) }}
                    {{ Form::hidden('project_id', old('project_id', $materialReceived->costCenters->project_id ?? null), ['class' => 'form-control','id' => 'project_id']) }}
                    {{ Form::hidden('cost_center_id', old('cost_center_id', $materialReceived->cost_center_id ?? null), ['class' => 'form-control','id' => 'cost_center_id']) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Remarks</label>
                    {{ Form::textarea('remarks',old('remarks') ? old('remarks') : (!empty($materialReceived->remarks) ? $materialReceived->remarks : null),['class' => 'form-control remarks', 'id' => 'remarks', 'autocomplete' => 'off', 'rows' => 2]) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="quality">Quality</label>
                    {{ Form::textarea('quality',old('quality') ? old('quality') : (!empty($materialReceived->quality) ? $materialReceived->quality : null),['class' => 'form-control quality', 'id' => 'quality', 'autocomplete' => 'off', 'rows' => 2]) }}
                </div>
            </div>
        </div><!-- end row -->

        <div id="material_and_quantity">
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
                <thead>
                    <tr>
                        <th width="200px">Floor Name</th>
                        <th width="250px">Material Name <span class="text-danger">*</span></th>
                        <th>Unit</th>
                        <th>Requisition<br>quantity</th>
                        {{-- <th>Present Stock<br>quantity</th> --}}
                        <th>Brand</th>
                        <th>Origin</th>
                        <th>Challan No.<span class="text-danger">*</span></th>
                        <th>Quantity<span class="text-danger">*</span></th>
                        <th>Ledger Folio No.</th>
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
                                    <input type="text" name="floor_name[]" value=""
                                        id="floor_name" class="form-control text-center form-control-sm floor_name">
                                    <input type="hidden" name="floor_id[]" value="{{ old('floor_id')[$key] ?? null }}" id="floor_id"
                                        class="form-control text-center form-control-sm floor_id">
                                </td>
                                <td>
                                    <input type="text" name="material_name[]" value="{{ old('material_name')[$key] }}"
                                        class="form-control text-center form-control-sm material_name">
                                    <input type="hidden" name="material_id[]" value="{{ old('material_id')[$key] }}"
                                        class="form-control text-center form-control-sm material_id">
                                </td>
                                <td>
                                    <input type="text" name="unit[]" value="{{ old('unit')[$key] }}"class="form-control form-control-sm text-center unit" readonly tabindex="-1">
                                </td>
                                <td>
                                    <input type="text" name="requisition_quantity[]" value="{{ old('requisition_quantity')[$key] }}"
                                    class="form-control form-control-sm text-center requisition_quantity" readonly
                                        tabindex="-1">
                                </td>
                                {{-- <td>
                                    <input type="text" name="mrr_quantity[]" value="{{ old('mrr_quantity')[$key] }}"
                                        class="form-control form-control-sm text-center mrr_quantity" readonly tabindex="-1">
                                </td> --}}
                                <td>
                                    <input type="text" name="brand[]" value="{{ old('brand')[$key] }}"
                                        class="form-control form-control-sm brand" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="origin[]" value="{{ old('origin')[$key] }}"
                                        class="form-control form-control-sm origin" autocomplete="off"></td>
                                <td>
                                    <input type="number" name="challan_no[]" value="{{ old('challan_no')[$key] }}"
                                        class="form-control form-control-sm challan_no" autocomplete="off">
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" value="{{ old('quantity')[$key] }}"
                                        class="form-control form-control-sm quantity" step="0.01" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" name="ledger_folio_no[]" value="{{ old('ledger_folio_no')[$key] }}"
                                        class="form-control form-control-sm ledger_folio_no" autocomplete="off">
                                </td>
                                <td>
                                    <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @if (!empty($materialReceived))
                            <input type="hidden" name="id" value="{{ $materialReceived->id }}">
                            @foreach ($materialReceived->materialreceivedetails as $materialreceivedetail)
                            {{-- @dd($materialreceivedetail->challan_no); --}}
                                <tr>
                                    <td>
                                        <select class="form-control form-control-sm material_name" name="material_id[]"
                                            >
                                            <option selected disabled>Select Floor </option>
                                            @foreach ($floors as $floor)
                                                <option value="{{ $floor->floor_id }}"
                                                    {{ $materialreceivedetail->floor_id == $floor->floor_id ? 'selected' : '' }}>
                                                    {{ $floor->boqFloor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="material_name[]"
                                            value="{{ $materialreceivedetail->nestedMaterials->name }}"
                                            class="form-control text-center form-control-sm material_name">
                                        <input type="hidden" name="material_id[]"
                                            value="{{ $materialreceivedetail->material_id }}"
                                            class="form-control form-control-sm text-center material_id">
                                    </td>
                                    <td><input type="text" name="unit[]"
                                            value="{{ $materialreceivedetail->nestedMaterials->unit->name }}"
                                            class="form-control form-control-sm text-center unit" readonly tabindex="-1"></td>

                                    <td><input type="text" name="requisition_quantity[]"
                                            value="{{ $materialReceived->purchaseorderForPo->mpr->requisitionDetails->first()->quantity ?? null }}"
                                            class="form-control form-control-sm text-center requisition_quantity" readonly
                                            autocomplete="off"></td>

                                        @php
                                            $present_stock = App\Procurement\StockHistory::where('cost_center_id', $materialReceived->cost_center_id)
                                                ->where('material_id', $materialreceivedetail->material_id)
                                                ->first();
                                        @endphp

                                    {{-- <td><input type="text" name="mrr_quantity[]"
                                            value="{{ $present_stock->present_stock ?? 0 }}"
                                            class="form-control form-control-sm text-center mrr_quantity received_quantity_{{$materialreceivedetail->material_id}}" readonly
                                            autocomplete="off"></td> --}}
                                    <td>
                                        <input type="text" name="brand[]" value="{{ $materialreceivedetail->brand }}" class="form-control form-control-sm text-center brand" autocomplete="off">
                                    </td>

                                    <td><input type="text" name="origin[]" value="{{ $materialreceivedetail->origin }}"
                                            class="form-control form-control-sm text-center origin" autocomplete="off"></td>
                                    <td><input type="number" name="challan_no[]"
                                            value="{{$materialreceivedetail->challan_no}}"
                                            class="form-control form-control-sm text-center challan_no" autocomplete="off"></td>

                                    <td><input type="number" name="quantity[]" value="{{ $materialreceivedetail->quantity }}"
                                            class="form-control form-control-sm text-center quantity mg_quanity_{{$materialreceivedetail->material_id}}" step="0.001" autocomplete="off"></td>

                                    <td><input type="text" name="ledger_folio_no[]"
                                            value="{{ $materialreceivedetail->ledger_folio_no }}"
                                            class="form-control form-control-sm text-center ledger_folio_no" autocomplete="off">
                                    </td>
                                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                                class="fa fa-minus"></i></button></td>
                                </tr>

                            @endforeach
                        @endif
                    @endif
                </tbody>
            </table>
        </div> <!-- end table responsive -->
    </div>

    <div class="withIou" style="{{ ((isset($materialReceived) && !empty($materialReceived->iou_id)) ? '': "display:none") }}">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name <span class="text-danger">*</span></label>
                    {{ Form::text('with_iou_project_name', old('with_iou_project_name', $materialReceived->costCenters->name ?? null), ['class' => 'form-control','id' => 'with_iou_project_name','tabindex' => -1,'autocomplete' => 'off']) }}
                    {{ Form::hidden('with_iou_project_id', old('with_iou_project_id', $materialReceived->costCenters->project_id ?? null), ['class' => 'form-control','id' => 'with_iou_project_id']) }}
                    {{ Form::hidden('with_iou_cost_center_id', old('with_iou_cost_center_id', $materialReceived->cost_center_id ?? null), ['class' => 'form-control','id' => 'with_iou_cost_center_id']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Iou No<span class="text-danger">*</span></label>
                    {{ Form::text('iou_no', old('iou_no', $materialReceived->iou->iou_no ?? null), ['class' => 'form-control','id' => 'iou_no','tabindex' => -1,'autocomplete' => 'off']) }}
                    {{ Form::hidden('iou_id', old('iou_id', $materialReceived->iou_id ?? null), ['class' => 'form-control','id' => 'iou_id']) }}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary" id="iou_mpr_no">
                    @if (isset($materialReceived->requisition_id))
                    <label class="input-group-addon">MPR No</label>
                    <input type="text" name="mpr_no" id="mpr_no" class="form-control" readonly value="{{$materialReceived->mpr->mpr_no}}"/>
                    <input type="hidden" name="requisition_id" id="requisition_id" class="form-control" readonly value="{{$materialReceived->requisition_id}}"/>
                    @elseif (old('mpr_no'))
                    <label class="input-group-addon">MPR No</label>
                    <input type="text" name="mpr_no" id="mpr_no" class="form-control" readonly value="{{old('mpr_no')}}"/>
                    <input type="hidden" name="requisition_id" id="requisition_id" class="form-control" readonly value="{{old('requisition_id')}}"/>
                    @endif
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm text-center" id="itemTableWithIou">
                <thead>
                    <tr>
                        <th width="250px">Material<span class="text-danger">*</span></th>
                        <th>Unit</th>
                        <th>Purpose</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>
                            <button class="btn btn-success btn-sm addItemWithIou" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (old('material_id'))
                        @foreach (old('material_id') as $key => $materialOldData)
                            <tr>
                                <td>

                                    <input type="text" name="material_name[]" value="{{ old('material_name')[$key] }}"
                                        class="form-control text-center form-control-sm material_name">
                                    <input type="hidden" name="material_id[]" value="{{ old('material_id')[$key] }}"
                                        class="form-control text-center form-control-sm material_id">
                                </td>
                                <td>
                                    <input type="text" name="unit[]" value="{{ old('unit')[$key] }}"class="form-control form-control-sm text-center unit" readonly tabindex="-1">
                                </td>
                                <td>
                                    <input type="text" name="requisition_quantity[]" value="{{ old('requisition_quantity')[$key] }}"
                                    class="form-control form-control-sm text-center requisition_quantity" readonly
                                        tabindex="-1">
                                </td>
                                {{-- <td>
                                    <input type="text" name="mrr_quantity[]" value="{{ old('mrr_quantity')[$key] }}"
                                        class="form-control form-control-sm text-center mrr_quantity" readonly tabindex="-1">
                                </td> --}}
                                <td>
                                    <input type="text" name="brand[]" value="{{ old('brand')[$key] }}"
                                        class="form-control form-control-sm brand" autocomplete="off">
                                </td>

                                <td>
                                    <button class="btn btn-danger btn-sm deleteItemwithIou" type="button" tabindex="-1">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @if (!empty($materialReceived))
                            <input type="hidden" name="id" value="{{ $materialReceived->id }}">
                            @foreach ($materialReceived->materialreceivedetails as $materialreceivedetail)
                                <tr>

                                    <td>
                                        <input type="text" name="with_iou_material_name[]"
                                            value="{{ $materialreceivedetail->nestedMaterials->name }}"
                                            class="form-control text-center form-control-sm with_iou_material_name">
                                        <input type="hidden" name="with_iou_material_id[]"
                                            value="{{ $materialreceivedetail->material_id }}"
                                            class="form-control form-control-sm text-center with_iou_material_id">
                                    </td>
                                    <td><input type="text" name="with_iou_material_unit[]"
                                            value="{{ $materialreceivedetail->nestedMaterials->unit->name }}"
                                            class="form-control form-control-sm text-center with_iou_material_unit" readonly tabindex="-1"></td>


                                    <td><input type="text" name="purpose[]" value="{{ $materialreceivedetail->purpose }}"
                                            class="form-control form-control-sm text-center purpose" autocomplete="off"></td>

                                    <td><input type="text" name="with_iou_material_qty[]" value="{{ $materialreceivedetail->quantity }}"
                                            class="form-control form-control-sm text-center with_iou_material_qty" autocomplete="off"></td>
                                    <td><input type="text" name="rate[]"
                                            value="{{ $materialreceivedetail->rate }}"
                                            class="form-control form-control-sm text-center rate" autocomplete="off"></td>


                                    <td><button class="btn btn-danger btn-sm deleteItemwithIou" type="button" tabindex="-1"><i
                                                class="fa fa-minus"></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="mrr_no">MRR No.<span class="text-danger">*</span></label>
                {{ Form::number('mrr_no',old('mrr_no') ? old('mrr_no') : (!empty($materialReceived->mrr_no) ? $materialReceived->mrr_no : null),['class' => 'form-control', 'id' => 'mrr_no', 'placeholder' => 'Enter MRR No.', 'autocomplete' => 'off']) }}
                {{ Form::hidden('mrr_id',old('mrr_id') ? old('mrr_id') : (!empty($materialReceived->id) ? $materialReceived->id : null),['class' => 'form-control', 'id' => 'mrr_id', 'autocomplete' => 'off']) }}
            </div>
        </div>
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
        var max_quantity  = [];

        var po_id = '';

        function addRow() {
            let row = `
                <tr>
                    <td>
                        <select class ="form-control form-control-sm floor_name"  name="floor_id[]" id="floor_name" autocomplete="off">
                            <option value=""></option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id" id="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off"  placeholder="Material Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control text-center form-control-
                         unit" readonly tabindex="-1"></td>
                    <td><input type="text" name="requisition_quantity[]" class="form-control text-center form-control-sm requisition_quantity" readonly tabindex="-1"></td>
                    <td><input type="text" name="brand[]" class="form-control text-center form-control-sm brand" autocomplete="off"></td>
                    <td><input type="text" name="origin[]" class="form-control text-center form-control-sm origin" autocomplete="off"  ></td>
                    <td><input type="number" name="challan_no[]" class="form-control text-center form-control-sm challan_no" autocomplete="off"  ></td>
                    <td><input type="number" name="quantity[]" class="form-control text-center form-control-sm quantity" step="0.001" placeholder="0.000"autocomplete="off"  ></td>
                    <td><input type="text" name="ledger_folio_no[]" class="form-control text-center form-control-sm ledger_folio_no" autocomplete="off"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);

        }


        function addRowwithIou() {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="with_iou_material_id[]" class="with_iou_material_id" id="with_iou_material_id">
                        <input type="text" name="with_iou_material_name[]" class="form-control text-center form-control-sm with_iou_material_name" autocomplete="off"  placeholder="Material Name">
                    </td>
                    <td><input type="text" name="with_iou_material_unit[]" class="form-control text-center form-control-sm with_iou_material_unit" readonly tabindex="-1"></td>
                    <td><input type="text" name="purpose[]" class="form-control text-center form-control-sm purpose" tabindex="-1"></td>
                    <td><input type="text" name="with_iou_material_qty[]" class="form-control text-center form-control-sm with_iou_material_qty" tabindex="-1"></td>
                    <td><input type="text" name="rate[]" class="form-control text-center form-control-sm rate" autocomplete="off"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTableWithIou tbody').append(row);

        }
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {

            // check double entry protection of material for a floor
            function checkFloorWiseMaterialDoubleEntry(currentRow){
                let costCenterId         = $("#cost_center_id").val();
                let currentFloorId       = $(currentRow).closest('tr').find(".floor_name").val();
                let currentMaterialId    = $(currentRow).closest('tr').find(".material_id").val();
                let currentFloorMaterial = `${currentFloorId}-${currentMaterialId}`;
                let materialNames        = $(".floor_name").not($(currentRow).closest('tr').find(".floor_name"));

                materialNames.each(function(){
                    let floorId       = $(this).closest('tr').find(".floor_name").val();
                    let materialId    = $(this).closest('tr').find(".material_id").val();
                    let floorMaterial = `${floorId}-${materialId}`;
                    if(floorId){
                        if(floorMaterial == currentFloorMaterial){
                            alert("Duplicate Found");
                            $(this).closest('tr').remove();
                        }
                    }else{
                        if(materialId == currentMaterialId){
                            alert("Duplicate Found");
                            $(this).closest('tr').remove();
                        }
                    }
                });
            }


            @if ($formType == 'create' && !old('material_id'))
                addRow();
                addRowwithIou();
            @endif


            // function for MPR wise po, po_no, po_date, project_id

                $("#mpr_no").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.MprAutoSuggestWithPO') }}",
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
                        $('#mpr_no').val(ui.item.value);
                        $('#mpr_id').val(ui.item.mpr_id);
                        $('#project_id').val(ui.item.project_id);
                        $('#project_name').val(ui.item.project_name);
                        $('#cost_center_id').val(ui.item.cost_center_id);
                        $('#po_id').val(ui.item.po_id);
                        loadMprWisePOList();
                        loadMPRWiseFloor();
                        return false;
                    }
                });

            // Function for autocompletion of floor by requisition_id

            function loadMPRWiseFloor() {
                let requisition_id = $("#mpr_id").val();
                if (requisition_id) {
                    const url = '{{ url('scj/loadMPRWiseFloor') }}/' + requisition_id;
                    let dropdown;+

                    $('.floor_name').each(function() {
                        dropdown = $(this).closest('tr').find('.floor_name');
                    });
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Floor</option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function(items) {

                        $.each(items, function(key, data) {
                            dropdown.append($(`<option>Select Floor</option>`)
                                .attr('value', data.value)
                                .text(data.label));
                        })
                    });
                }
            };

            function loadMPRWiseFloorWithSelect(floor_id,returnOption) {
                let requisition_id = $("#mpr_id").val();
                if (requisition_id) {
                    const url = '{{ url('scj/loadMPRWiseFloor') }}/' + requisition_id;

                    var option_value = '<option selected disabled>Select Floor</option>'
                    $.getJSON(url, function(items) {

                        $.each(items, function(key, data) {
                            let selected = (data.value == floor_id) ? 'selected' : '';
                            option_value += `<option value='${data.value}' ${selected} >${data.label}</option>`
                          ;
                        })
                        returnOption(option_value);
                    });


                }
            };

            //searching materials...
            $(document).on('keyup', ".material_name", function() {
                let po_no = $("#po_no").val();
                let po_id = $("#po_id").val();
                let requisition_id = $("#mpr_id").val();
                let project_id = $("#project_id").val();
                let cost_center_id = $("#cost_center_id").val();
                let floor_name = $(this).closest('tr').find(".floor_name").val();

                if (requisition_id) {
                    if (po_no) {
                        if (project_id && floor_name) {
                            $(this).autocomplete({
                                source: function(request, response) {
                                    $.ajax({
                                        url: '{{ route('scj.floorWsiseRequisitionMaterials') }}',
                                        type: 'get',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            search: request.term,
                                            requisition_id: requisition_id,
                                            floor_name: floor_name,
                                            po_no: po_no
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
                                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                                    $(this).closest('tr').find('.requisition_quantity').val(ui.item.quantity);
                                    let material_id = ui.item.material_id;
                                    $.ajax({
                                        url: '{{ route('scj.getPresentStockQuantity') }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            cost_center_id: cost_center_id,
                                            po_no: po_no,
                                            floor_name: floor_name,
                                            material_id: material_id,
                                            po_id: po_id,
                                        },
                                        success: function(data) {
                                            // $(vm).closest('tr').find('.mrr_quantity').val(data.mrr_quantity);
                                            $(vm).closest('tr').find('.brand').val(data.po_brand);
                                        }
                                    });
                                    $.ajax({
                                        url: '{{ route('scj.getMrrDetailsByProjectAndMaterial') }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            requisition_id: requisition_id,
                                            cost_center_id: cost_center_id,
                                            project_id: project_id,
                                            floor_name: floor_name,
                                            material_id: material_id,
                                            po_no: po_no
                                        },
                                        success: function(data) {
                                            console.log(data);
                                            var materialClass = $(".material_id").each(function() {
                                                return "mg_quanity_"+$(this).val();
                                                });

                                            // Filter only unique ones
                                            var uniqueClasses = $.unique(materialClass);

                                            // Now group them
                                            $(uniqueClasses).each(function(i, v) {
                                                var mrr_total = 0;
                                                $(".mg_quanity_"+$(v).val()).each(function(){
                                                    if(parseInt($(this).val()) > 0)
                                                    {
                                                        mrr_total += parseInt($(this).val());
                                                    }
                                                });

                                                // let po_quantity = 0;
                                                // $(max_quantity).each(function(index, item){
                                                //     if(item[0] == material_id)
                                                //     {
                                                //         po_quantity = parseInt(item[1])
                                                //     }
                                                // })
                                                let total_material_receive_before_stock_inn = data.material_receive_quantity_sum;
                                                let max = data.total_material_qty_in_po - total_material_receive_before_stock_inn;
                                                // let max = data.total_material_qty_in_po - parseInt(mrr_total) - total_material_receive_before_stock_inn;
                                                $(vm).closest('tr').find(".quantity").addClass('mg_quanity_' + material_id).attr('max', parseInt(max));
                                                // $(vm).closest('tr').find(".mrr_quantity").addClass('received_quantity_' + material_id);
                                            });
                                        }
                                    });
                                    checkFloorWiseMaterialDoubleEntry($(this));
                                }
                            });
                        } else if (project_id) {
                            $(this).autocomplete({
                                source: function(request, response) {
                                    $.ajax({
                                        url: '{{ route('scj.projectWsiseRequisitionMaterials') }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            search: request.term,
                                            requisition_id: requisition_id,
                                            po_no: po_no
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
                                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                                    $(this).closest('tr').find('.requisition_quantity').val(ui.item.quantity);
                                    let material_id = ui.item.material_id;

                                    $.ajax({
                                        url: '{{ route('scj.getPresentStockQuantity') }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            cost_center_id: cost_center_id,
                                            po_no: po_no,
                                            floor_name: floor_name,
                                            material_id: material_id,
                                            po_id: po_id,
                                        },
                                        success: function(data) {
                                            // $(vm).closest('tr').find('.mrr_quantity').val(data.mrr_quantity);
                                            $(vm).closest('tr').find('.brand').val(data.po_brand);
                                        }
                                    });

                                    $.ajax({
                                        url: '{{ route('scj.getMrrDetailsByProjectAndMaterial') }}',

                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            requisition_id: requisition_id,
                                            cost_center_id: cost_center_id,
                                            project_id: project_id,
                                            material_id: material_id,
                                            po_no: po_no

                                        },
                                        success: function(data) {
                                            var materialClass = $(".material_id").each(function() {
                                                return "mg_quanity_"+$(this).val();
                                                });

                                            // Filter only unique ones
                                            var uniqueClasses = $.unique(materialClass);

                                            // Now group them
                                            $(uniqueClasses).each(function(i, v) {
                                                var mrr_total = 0;
                                                $(".mg_quanity_"+$(v).val()).each(function(){
                                                    if(parseInt($(this).val()) > 0)
                                                    {
                                                        mrr_total += parseInt($(this).val());
                                                    }
                                                });

                                                // let po_quantity = 0;
                                                // $(max_quantity).each(function(index, item){
                                                //     if(item[0] == material_id)
                                                //     {
                                                //         po_quantity = parseInt(item[1])
                                                //     }
                                                // })
                                                let total_material_receive_before_stock_inn = data.material_receive_quantity_sum;
                                                console.log(parseInt(mrr_total))
                                                console.log(data.total_material_qty_in_po)
                                                let max = data.total_material_qty_in_po - total_material_receive_before_stock_inn;
                                                // let max = data.total_material_qty_in_po - parseInt(mrr_total) - total_material_receive_before_stock_inn;
                                                $(vm).closest('tr').find(".quantity").addClass('mg_quanity_' + material_id).attr('max', parseInt(max));
                                                // $(vm).closest('tr').find(".mrr_quantity").addClass('received_quantity_' + material_id);
                                            });
                                        }
                                    });
                                    checkFloorWiseMaterialDoubleEntry($(this));
                                }
                            });
                        } else if (project_id === "") {
                            $(this).autocomplete({
                                source: function(request, response) {
                                    $.ajax({
                                        url: '{{ route('scj.headOfficeWiseRequisitionMaterials') }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            search: request.term,
                                            requisition_id: requisition_id,
                                            po_no: po_no
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
                                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                                    $(this).closest('tr').find('.requisition_quantity').val(ui.item.quantity);
                                    let material_id = ui.item.material_id;

                                    $.ajax({
                                        url: '{{ route('scj.getPresentStockQuantity') }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            cost_center_id: cost_center_id,
                                            po_no: po_no,
                                            floor_name: floor_name,
                                            material_id: material_id,
                                            po_id: po_id
                                        },
                                        success: function(data) {
                                            // $(vm).closest('tr').find(
                                            //     '.mrr_quantity').val(data
                                            //     .mrr_quantity);
                                             $(vm).closest('tr').find('.brand').val(data.po_brand);
                                        }
                                    });
                                    $.ajax({
                                        url: '{{ route('scj.getMrrDetailsByProjectAndMaterial') }}',

                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            requisition_id: requisition_id,
                                            cost_center_id: cost_center_id,
                                            material_id: material_id,
                                            po_no: po_no
                                        },
                                        success: function(data) {
                                            var materialClass = $(".material_id").each(function() {
                                                return "mg_quanity_"+$(this).val();
                                                });

                                            // Filter only unique ones
                                            var uniqueClasses = $.unique(materialClass);

                                            // Now group them
                                            $(uniqueClasses).each(function(i, v) {
                                                var mrr_total = 0;
                                                $(".mg_quanity_"+$(v).val()).each(function(){
                                                    if(parseInt($(this).val()) > 0)
                                                    {
                                                        mrr_total += parseInt($(this).val());
                                                    }
                                                });
                                                let total_material_receive_before_stock_inn = data.material_receive_quantity_sum;
                                                let max = data.total_material_qty_in_po - total_material_receive_before_stock_inn;
                                                // let max = data.total_material_qty_in_po - parseInt(mrr_total) - total_material_receive_before_stock_inn;
                                                $(vm).closest('tr').find(".quantity").addClass('mg_quanity_' + material_id).attr('max', parseInt(max));
                                                // $(vm).closest('tr').find(".mrr_quantity").addClass('received_quantity_' + material_id);
                                            });
                                        }
                                    });
                                }
                            });
                        } else {
                            $(document).on('keyup', ".material_name", function() {
                                if (requisition_id = "null") {
                                    alert("Data Not Available");
                                    $("#itemTable").find("tbody").children("tr").remove();
                                    addRow();
                                }
                            });
                        }
                    } else {
                        $(document).on('keyup', ".material_name", function() {
                            alert("Select PO first");
                            $("#itemTable").find("tbody").children("tr").remove();
                            addRow();
                            location.reload();
                        });
                    }
                } else {
                    $(document).on('keyup', ".material_name", function() {
                        alert("Search MPR first");
                        $("#itemTable").find("tbody").children("tr").remove();
                        addRow();
                    });
                }
            });
            function getAllInfoForRow(material_id,floor_id,getResult){
                let po_no = $("#po_no").val();
                let requisition_id = $("#mpr_id").val();
                let project_id = $("#project_id").val();
                let cost_center_id = $("#cost_center_id").val();
                let po_id = $("#po_id").val();
                $.ajax({
                        url: '{{ route('scj.getRequisitionMaterialDetailsForRow') }}',
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            material_id: material_id,
                            requisition_id: requisition_id,
                            floor_id: floor_id,
                            cost_center_id: cost_center_id,
                            po_no : po_no,
                            po_id : po_id
                        },
                        success: function(data) {
                            getResult(data);
                        }
                    });
            }
                            function GetMax(data){

                            /********/
                            var materialClass = $(".material_id").each(function() {
                                                return "mg_quanity_"+$(this).val();
                                                });

                            // Filter only unique ones
                            var uniqueClasses = $.unique(materialClass);

                            // Now group them
                            $(uniqueClasses).each(function(i, v) {
                                let mrr_total = 0;
                                $(".mg_quanity_"+$(v).val()).each(function(){
                                    if(parseInt($(this).val()) > 0){
                                        mrr_total += parseInt($(this).val());
                                    }
                                });
                                let total_material_receive_before_stock_inn = data.material_receive_quantity_sum;
                                let max = data.total_material_qty_in_po - total_material_receive_before_stock_inn;
                                if(max){
                                    return max;
                                }else{
                                    return 0
                                }
                                return max;
                            });
}
            function add_new_row(material_id, material_name, floor_id) {
                getAllInfoForRow(material_id, floor_id, function(data) {
                var max_data = GetMax(data);
                    loadMPRWiseFloorWithSelect(floor_id, function(selectOption) {
                    let row = `
                    <tr>
                        <td>
                            <select class ="form-control form-control-sm floor_name"  name="floor_id[]" id="floor_name" autocomplete="off">
                            ${selectOption}
                            </select>
                        </td>
                        <td>
                            <input type="hidden" name="material_id[]" class="material_id" id="material_id" value='${material_id}'>
                            <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off"  placeholder="Material Name" value='${material_name}'>
                        </td>
                        <td><input type="text" name="unit[]" class="form-control text-center form-control-sm unit" readonly tabindex="-1" value='${data.unit}'></td>
                        <td><input type="text" name="requisition_quantity[]" class="form-control text-center form-control-sm requisition_quantity" value='${data.quantity}' readonly tabindex="-1"></td>
                        <td><input type="text" name="brand[]" class="form-control text-center form-control-sm brand" autocomplete="off" value='${data.brand}'></td>
                        <td><input type="text" name="origin[]" class="form-control text-center form-control-sm origin" autocomplete="off"  ></td>
                        <td><input type="number" name="challan_no[]" class="form-control text-center form-control-sm challan_no" autocomplete="off"  ></td>
                        <td><input type="number" name="quantity[]" class="form-control text-center form-control-sm quantity ${'mg_quanity_'+material_id}" step="0.001" max='${max_data}' placeholder="0.000"autocomplete="off" ></td>
                        <td><input type="text" name="ledger_folio_no[]" class="form-control text-center form-control-sm ledger_folio_no" autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                    `;
                    $('#itemTable tbody').append(row);
                });
            });
        }



            // Function for getting CS supplier repair
            function loadMprWisePOList() {
                const mpr_id = $("#mpr_id").val();
                if (mpr_id != '') {
                    const url = '{{ url('loadMPRWisePo') }}/' + mpr_id;
                    let dropdown = $('#po_no');
                    let oldSelectedItem = "{{ old('po_no', $materialReceived->po_no ?? '') }}";

                    dropdown.empty();
                    dropdown.append('<option selected="true" disabled>Select PO No </option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function(items) {
                        $.each(items, function(key, mpr_id) {
                            let select = (oldSelectedItem == mpr_id.id) ? "selected" : null;
                            let options =
                                `<option value="${mpr_id.po_no}" ${select}>${mpr_id.po_no}</option>`;
                            dropdown.append(options);
                        })
                    });
                }
            }


            // function for getting cs refference no by po_no

            function getCSReferrenceByPoNo() {
                let po_no = $("#po_no").val();
                let url = '{{ url('getCSReferrenceByPoNo') }}/' + po_no;

                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(CSReferrence) {
                        $('#cs_no').val(CSReferrence[0].cs.reference_no);
                        $('#po_dated').val(CSReferrence[0].date);
                    })
            }


            // function for getting materials and quantity by po_no
            function getMaterialsAndQuantityByPoNo() {
                let po_no = $("#po_no").val();
                let url = '{{ url('scj/getMaterialsAndQuantityByPoNo') }}/' + po_no;

                $.getJSON(url, function(items) {
                    $('#material_and_quantity').empty();
                    $('#itemTable tbody tr').empty();

                    $.each(items, function(key, data) {

                        let info =
                            '<span class="label label-success tableBadge material_and_quantity" id="">' +
                            data.material_name + ' --- Q(' + data.po_quantity + ')---P(' + data.po_price + ')</span>';
                        $('#material_and_quantity').append(info);
                        // add_new_row(data.material_id,data.material_name);
                        max_quantity.push([material = data.material_id, quantity = data.po_quantity]);

                    })

                });
            }

            function getMaterialsAndQuantityByMprNo() {
                let mpr_no = $("#mpr_no").val();
                let po_no = $("#po_no").val();
                let url = '{{ url('scj/getMaterialsAndQuantityByMprNo') }}/' + mpr_no + "/" + po_no;

                $.getJSON(url, function(items) {
                    $.each(items, function(key, data) {
                        add_new_row(data.material_id,data.material_name, data.floor_id);

                    })
                });
            }

            $("#itemTable").on('click', ".addItem", function() {
                addRow();
                loadMPRWiseFloor(this);
                }).on('click', '.deleteItem', function() {
                    $(this).closest('tr').remove();
            });
            $("#itemTableWithIou").on('click', ".addItemWithIou", function() {
                addRowwithIou();
                }).on('click', '.deleteItemwithIou', function() {
                    $(this).closest('tr').remove();
            });

            $('#date').datepicker({
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
                    showOtherMonths: true
                });
            });

            $(document).on('change', '#po_no', function() {
                getCSReferrenceByPoNo();
                getMaterialsAndQuantityByPoNo();
                getMaterialsAndQuantityByMprNo();
            });

            @if ($formType == 'edit')
                // getMaterialsAndQuantityByPoNo();
            @endif


        });

        //function for counting material total and restrict for maximum value

        $(document).on('click, focus', '.quantity', function() {
            var className = $(this).closest('tr').find(".quantity").attr('class')
            let classArray = className.split(' ');
            let lastClass = classArray[classArray.length - 1];
            let materialArray = lastClass.split('_');
            let material_id = materialArray[materialArray.length - 1]

            let po_quantity = 0;
            $(max_quantity).each(function(index, item){
                if(item[0] == material_id)
                {
                    po_quantity = parseInt(item[1])
                }
            })

            let mrr_total = 0;
            $(".mg_quanity_"+material_id).each(function(index, item){
                if(parseInt(item.value) > 0)
                {
                    mrr_total += parseInt(item.value);
                }
            });

            console.log(mrr_total);

            let received = 0;
            $(".received_quantity_"+material_id).each(function(index, item){
                if(parseInt(item.value) > 0)
                {
                    received += parseInt(item.value);
                }
            });

            let max = 0
            @if($formType != 'edit')
                po_quantity -= received
            @endif
            if(parseInt($(this).val()) > 0)
            {
                max = parseInt(po_quantity) - parseInt(mrr_total) + parseInt($(this).val());
            } else {
                max = parseInt(po_quantity) - parseInt(mrr_total)
            }
            if(max < 0)
            {
                max = 0
            }
            $(this).closest('tr').find(".quantity").addClass('mg_quanity_' + material_id).attr('max', parseInt(max));

        });
        $("#with_iou_project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.projectAutoSuggestwithCostCenter')}}",
                        type: 'get',
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
                    $('#with_iou_project_name').val(ui.item.label);
                    $('#with_iou_project_id').val(ui.item.project_id);
                    $('#with_iou_cost_center_id').val(ui.item.value);
                    return false;
                }
                });

        $(document).ready(function(){
            $('#withIou').click(function() {
            $('.withOutIou').hide("fade");
            $('.withIou').show("fade");
            });
        });
        $(document).ready(function(){
            $('#withOutIou').click(function() {
            $('.withIou').hide("fade");
            $('.withOutIou').show("fade");
            });
        });
        $(document).on('keyup', "#iou_no", function(){
                $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.SearchIouNo')}}",
                        type: 'get',
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
                select: function (event, ui) {

                    $(this).val(ui.item.label);
                    $('#iou_id').val(ui.item.value);
                    $('#iou_mpr_no').html('');
                    if(ui.item.requisition_id){
                        let info = '<label class="input-group-addon">MPR No</label>' +
                        '<input type="text" name="mpr_no" id="mpr_no" class="form-control" readonly value="' + ui.item.mpr_no +'"/>' +
                        '<input type="hidden" name="requisition_id" id="requisition_id" class="form-control" readonly value="'+ ui.item.requisition_id+'"/>'
                        $('#iou_mpr_no').append(info);
                    }
                    return false;
                }
            });

            });

            $(document).on('keyup', ".with_iou_material_name", function(){
            let project_id = $("#with_iou_project_id").val();
            let cost_center_id = $("#with_iou_cost_center_id").val();
            // alert(cost_center_id);
            $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.materialAutoSuggestHavingBoqOrAll') }}",
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                project_id: project_id,
                                cost_center_id: cost_center_id
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.with_iou_material_name').val(ui.item.label);
                        $(this).closest('tr').find('.with_iou_material_id').val(ui.item.material_id);
                        $(this).closest('tr').find('.with_iou_material_unit').val(ui.item.unit.name);
                        getBoqBudgetMax(this,ui.item.material_id);
                    }
                });

            })


            function getBoqBudgetMax(parent,material_id){
                let project_id = $('#with_iou_project_id').val();
                    $.ajax({
                    url: "{{ route('scj.getBoqBudgetMax') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        material_id: material_id,
                        project_id : project_id
                    },
                    success: function(data) {
                        if(data == 0){
                            data = null;
                        }
                        $(parent).closest('tr').find('.with_iou_material_qty').attr('max',data);
                    }
                });
            }
    </script>
@endsection
