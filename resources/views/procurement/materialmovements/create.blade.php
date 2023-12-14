@extends('layouts.backend-layout')
@section('title', 'Material Movements')

@section('breadcrumb-title')
    @if(!empty($materialmovement))
        Edit Material Movement
    @else
        Add Material Movement
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('materialmovements') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')

    @if(!empty($materialmovement))
        {!! Form::open(array('url' => "materialmovements/$materialmovement->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "materialmovements",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="mto_no">MTO NO <span class="text-danger">*</span></label>
                    {{Form::text('mto_no', old('mto_no') ? old('mto_no') : (!empty($materialmovement) ? $materialmovement->mto_no : null),['class' => 'form-control','id' => 'mto_no', 'autocomplete'=>"off", 'placeholder' => ''])}}
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Transfer Date <span class="text-danger">*</span></label>
                    {{Form::text('transfer_date', old('transfer_date') ? old('transfer_date') : (!empty($materialmovement->transfer_date) ? $materialmovement->transfer_date : null),['class' => 'form-control transfer_date','id' => 'transfer_date', 'autocomplete'=>"off", 'required', 'readonly'])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">From Project <span class="text-danger">*</span></label>
                    {{Form::text('from_costcenter_name', old('from_costcenter_name') ? old('from_costcenter_name') :
                        (!empty($materialmovement) ? $materialmovement->movementdetails->first()->movementRequisition->fromCostCenter->name : null),['class' => 'form-control','id' => 'from_costcenter_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('from_costcenter_id', old('from_costcenter_id') ? old('from_costcenter_id') : (!empty($materialmovement) ? $materialmovement->movementdetails->first()->movementRequisition->from_costcenter_id: null),['class' => 'form-control','id' => 'from_costcenter_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">To Project <span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($materialmovement) ? $materialmovement->movementdetails->first()->movementRequisition->toCostCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($materialmovement) ? $materialmovement->movementdetails->first()->movementRequisition->to_costcenter_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>

        </div><!-- end row -->

    <hr class="bg-success">

        @php
            $details = old('movement_requisition_id', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('movementRequisition.id') : []);
            $gate_pass = old('gate_pass', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('gate_pass') : []);
            $materials = old('material_id', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('nestedMaterial.name') : []);
            $material_id = old('material_id', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('material_id') : []);
            $units = old('unit', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('nestedMaterial.unit.name') : []);
            $mtrfQuantity = old('mtrf_quantity', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('movementRequisition.movementRequisitionDetails') : []);
            $mtoQuantity = old('mto_quantity', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('quantity') : []);
            $remarks = old('remarks', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('remarks') : []);
            $tag = old('tag', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('fixed_asset_id') : []);

        @endphp
        <div class="table-responsive">
            <table id="purchaseTable" class="table table-striped table-bordered" >
                <thead>
                <tr>
                    <th>MTRF  <span class="text-danger">*</span></th>
                    <th>GP  <span class="text-danger">*</span></th>
                    <th>Material Name <span class="text-danger">*</span></th>
                    <th>Unit</th>
                    <th>MTR Quantity</th>
                    <th>Tag</th>
                    <th>MTO Quantity</th>
                    <th>Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
                </thead>
                <tbody>

                @if(!empty($details))
                    @foreach($details as $key => $detail)
                    @php
                        $mtrfQuantit = !empty($materialmovement) ? $mtrfQuantity[$key]->where('material_id',$material_id[$key])->first() : old('mtrf_quantity');
                        $Tags = \App\Accounts\FixedAsset::where('material_id',$material_id[$key])->pluck('tag','id');
                        //$material =
                    @endphp
                    <tr>
                        <td>
                            {{Form::select('movement_requisition_id[]', $requisitions, $detail, ['class' => 'form-control mtrf_no', 'placeholder'=>" Select MTRF", 'autocomplete'=>"off"])}}
                        </td>
                        <td>{{Form::text('gate_pass[]', $gate_pass[$key], ['class' => 'form-control gate_pass',   'autocomplete'=>"off"])}}</td>
                        <td>
                            {{Form::hidden('material_id[]', $material_id[$key], ['class' => 'form-control material_id', 'placeholder'=>" Select MTRF", 'autocomplete'=>"off"])}}
                             {{Form::text('material_name[]', $materials[$key], ['class' => 'form-control material', 'placeholder'=>"Search Material", 'autocomplete'=>"off"])}}
                            </td>
                        <td>{{Form::text('unit[]', $units[$key], ['class' => 'form-control unit text-center',  'readonly'])}}</td>
                        <td>{{Form::text('mtrf_quantity[]', $mtrfQuantit->quantity ?? 0, ['class' => 'form-control mtrf_quantity text-center',  'readonly'])}}</td>
                        <td>{{Form::select('tag[]', $Tags,$tag[$key], ['class' => 'form-control mtrf_no', 'placeholder'=>"Select Tag", 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('mto_quantity[]', $mtoQuantity[$key] ?? null , ['class' => 'form-control mto_quantity text-center', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('remarks[]', $remarks[$key] ?? null, ['class' => 'form-control unit', 'autocomplete'=>"off"])}}</td>

                        <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                    </tr>
                    @endforeach
                @endif
                </tbody>

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

        $( "#from_costcenter_name").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('costCenterAutoSuggest')}}",
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
                $('#from_costcenter_id').val(ui.item.value);
                $('#from_costcenter_name').val(ui.item.label);
                $("#itemTable").find("tbody").children("tr").remove();
                loadMTRFProjectWise();
                return false;
            }
        });

        $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('costCenterAutoSuggest')}}",
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
                    $('#project_name').val(ui.item.label);
                    $("#itemTable").find("tbody").children("tr").remove();
                    loadMTRFProjectWise();
                    return false;
                }
            })

            function loadMTRFProjectWise(){
                let from_project = $("#from_costcenter_id").val();
                let to_project = $("#cost_center_id").val();
                let url ='{{url("loadMTRFProjectWise")}}/'+ from_project +'/' + to_project;
                fetch(url)
                .then((resp) => resp.json())
                .then(function(data) {
                        $(".mtrf_no").html('');
                        $(".mtrf_no").append(`<option value=""> Select MTRF</option>`);
                        $.each(data, function(materialItems, materialItem){
                            let option = `<option value="${materialItem.id}"> ${materialItem.mtrf_no}</option>`;
                            $(".mtrf_no").append(option);
                        });
                    })
                .catch(function () {
                });
            }

        // $(document).on('change', ".material_id", function(){
        //     let  mtrf_id = $(this).closest('tr').find('.mtrf_no').val();
        //     let url ='{{url("getMovementRequiestionInfo")}}/'+ mtrf_id;
        //     let  material_dropdown = $(this).closest('tr').find('.material_id');
        //     material_dropdown.empty();
        //     material_dropdown.append('<option selected="true" disabled>Select Material </option>')
        //     fetch(url)
        //     .then((resp) => resp.json())
        //     .then(function(data) {
        //             // $(this).closest('tr').find('.from_costcenter_name').val(data.from_cost_center.name);
        //             // $(this).closest('tr').find('.from_costcenter_id').val(data.from_cost_center.id);
        //             // $(this).closest('tr').find('.to_costcenter_name').val(data.to_cost_center.name);
        //             // $(this).closest('tr').find('.to_costcenter_id').val(data.to_cost_center.id);
        //             console.log(data.movement_requisition_details.nested_material);
        //             $.each(data.movement_requisition_details, function(materialItems, materialItem){
        //                 let option = `<option value="${materialItem.nested_material.id}"> ${materialItem.nested_material.name}</option>`;
        //                 material_dropdown.append(option);
        //             });

        //         })
        //     .catch(function () {
        //     });
        // });

        $(document).on('keyup', ".material", function(){
            let  mtrf_id = $(this).closest('tr').find('.mtrf_no').val();

            $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('scj.getMTRFInfobyMaterial')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                mtrf_id
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.material_id').val(ui.item.value);
                        $(this).closest('tr').find('.unit').val(ui.item.unit);
                        $(this).closest('tr').find('.mtrf_quantity').val(ui.item.mtr_qty);
                        let prnt = $(this)
                        let url ='{{url("scj/loadFixedCost")}}/'+ ui.item.value;
                        fetch(url)
                        .then((resp) => resp.json())
                        .then(function(data) {
                                if(data.length > 0) {
                                    prnt.closest('tr').find(".tag").html(null);
                                    prnt.closest('tr').find(".tag").append(`<option value=""> Select MTRF</option>`);
                                    console.log(data);
                                    $.each(data, function(materialItems, materialItem){
                                    let option = `<option value="${materialItem.id}">${materialItem.tag}</option>`;
                                    console.log(option);
                                    prnt.closest('tr').find(".tag").append(option);
                                });
                                }
                            })
                        .catch(function ($err) {
                        });
                        return false;
                    }
                });
        });

        function addItemDtl(){
            var Row = `
            <tr>
                <td>
                <select name="movement_requisition_id[]" class="form-control mtrf_no">
                    <option>Select MTRF</option> </select>
                </td>
                <td><input type="text" name="gate_pass[]" value="" class="form-control gate_pass"  autocomplete="off"></td>
                <td>
                    <input type="hidden" name="material_id[]"  class="form-control form-control-sm text-center material_id" autocomplete="off" tabindex="-1">
                    <input type="text" name="material_name[]"  class="form-control form-control-sm text-center material" autocomplete="off" tabindex="-1">
                </td>
                <td>
                    <input type="text" name="unit[]"  class="form-control form-control-sm text-center unit" id="unit_name" autocomplete="off" readonly tabindex="-1">
                </td>

                <td>
                    <input type="number" name="mtrf_quantity[]"  class="form-control mtrf_quantity text-center"  tabindex="-1" min="0" step="0.01" placeholder="0.00" autocomplete="off" readonly>
                </td>
                <td>
                  <select name="tag[]" class="form-control tag">
                    <option>Select Tag</option>
                  </select>
                </td>
                <td>
                    <input type="number" name="mto_quantity[]"  class="form-control mto_quantity text-center" min="0" step="0.01" placeholder="0.00" autocomplete="off">
                </td>
                <td>
                    <textarea rows="1" name="remarks[]"  class="form-control remarks text-center" tabindex="-1" autocomplete="off"></textarea>
                </td>
                <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;

            var tableItem = $('#purchaseTable').append(Row);
            $(this).closest('tr').find('.mtrf_no').empty();
            $(this).closest('tr').find('.mtrf_no').append('<option selected="true" disabled>Select MTRF </option>')
            loadMTRFProjectWise()
        }
        function removQRow(qval){
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if(empty($materialmovement))
                // addItemDtl();
            @endif
        });

        $(document).on('mouseenter', '.transfer_date', function() {
                $(this).datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });

        $(document).on('mouseenter', '.date', function() {
            $(this).datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        });

    </script>
@endsection
